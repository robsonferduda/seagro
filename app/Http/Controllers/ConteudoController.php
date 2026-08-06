<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Evento;
use App\Models\Video;
use App\Models\Boletim;
use App\Models\Noticia;
use App\Models\Pagina;
use App\Models\Oportunidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ConteudoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Session::put('url', 'gercont');

        $hoje = Carbon::today();
        $limite30 = Carbon::today()->addDays(30);
        $inicioMes = Carbon::now()->startOfMonth();

        $boletinsTotal = Boletim::count();
        $ultimoBoletim = Boletim::orderBy('dt_publicacao', 'desc')->first();

        $paginasTotal = Pagina::count();
        $paginasPublicadas = Pagina::where('fl_publicacao', 1)->count();

        $noticiasTotal = Noticia::count();
        $noticiasAtivas = Noticia::where('fl_ativa', 1)->count();
        $noticiasMes = Noticia::where('dt_noticia', '>=', $inicioMes)->count();

        $videosTotal = Video::count();
        $videosAtivos = Video::where('fl_ativo', 1)->count();

        $eventosAtivos = Evento::where('fl_ativo', 1)->count();
        $eventosProximos30 = Evento::where('fl_ativo', 1)
            ->whereBetween('data', [$hoje->toDateString(), $limite30->toDateString()])
            ->count();

        $oportunidadesAbertas = Oportunidade::where('fl_ativo', 1)
            ->where(function ($q) use ($hoje) {
                $q->whereNull('dt_validade')
                  ->orWhere('dt_validade', '>=', $hoje->toDateString());
            })
            ->count();

        $proximosEventos = Evento::with('tipo')
            ->where('fl_ativo', 1)
            ->where('data', '>=', $hoje->toDateString())
            ->orderBy('data')
            ->take(5)
            ->get();

        $atividadeRecente = collect();

        $ultimaNoticia = Noticia::orderBy('dt_noticia', 'desc')->first();
        if ($ultimaNoticia) {
            $atividadeRecente->push([
                'tipo' => 'noticia',
                'icone' => 'fa-newspaper-o',
                'cor' => 'dash-tone-green',
                'titulo' => $ultimaNoticia->titulo,
                'meta' => 'Notícia',
                'data' => $ultimaNoticia->dt_noticia,
                'url' => url('noticia-admin/' . $ultimaNoticia->id . '/edit'),
            ]);
        }

        if ($ultimoBoletim) {
            $atividadeRecente->push([
                'tipo' => 'boletim',
                'icone' => 'fa-files-o',
                'cor' => 'dash-tone-orange',
                'titulo' => $ultimoBoletim->titulo,
                'meta' => 'Boletim',
                'data' => $ultimoBoletim->dt_publicacao,
                'url' => url('boletim/' . $ultimoBoletim->id . '/edit'),
            ]);
        }

        $ultimoVideo = Video::orderBy('dt_video', 'desc')->orderBy('created_at', 'desc')->first();
        if ($ultimoVideo) {
            $atividadeRecente->push([
                'tipo' => 'video',
                'icone' => 'fa-video-camera',
                'cor' => 'dash-tone-red',
                'titulo' => $ultimoVideo->nm_video,
                'meta' => 'Vídeo',
                'data' => $ultimoVideo->dt_video ?: $ultimoVideo->created_at,
                'url' => url('video/' . $ultimoVideo->id . '/edit'),
            ]);
        }

        $ultimoEvento = Evento::orderBy('updated_at', 'desc')->first();
        if ($ultimoEvento) {
            $atividadeRecente->push([
                'tipo' => 'evento',
                'icone' => 'fa-calendar',
                'cor' => 'dash-tone-blue',
                'titulo' => $ultimoEvento->titulo,
                'meta' => 'Evento',
                'data' => $ultimoEvento->updated_at,
                'url' => route('evento.edit', $ultimoEvento),
            ]);
        }

        $ultimaOportunidade = Oportunidade::orderBy('dt_publicacao', 'desc')->first();
        if ($ultimaOportunidade) {
            $atividadeRecente->push([
                'tipo' => 'oportunidade',
                'icone' => 'fa-briefcase',
                'cor' => 'dash-tone-teal',
                'titulo' => $ultimaOportunidade->titulo,
                'meta' => 'Oportunidade',
                'data' => $ultimaOportunidade->dt_publicacao,
                'url' => url('oportunidade/' . $ultimaOportunidade->id . '/edit'),
            ]);
        }

        $atividadeRecente = $atividadeRecente
            ->sortByDesc(function ($item) {
                return Carbon::parse($item['data'])->timestamp;
            })
            ->take(6)
            ->values();

        $alertas = collect();

        $eventosRedirectSemUrl = Evento::where('fl_ativo', 1)
            ->where('tp_destino', 'redirect')
            ->where(function ($q) {
                $q->whereNull('url_destino')->orWhere('url_destino', '');
            })
            ->count();
        if ($eventosRedirectSemUrl > 0) {
            $alertas->push([
                'nivel' => 'warning',
                'texto' => $eventosRedirectSemUrl . ' evento(s) em modo redirect sem URL de destino.',
                'url' => url('gercont/eventos'),
            ]);
        }

        $eventosSemConteudo = Evento::where('fl_ativo', 1)
            ->where(function ($q) {
                $q->whereNull('tp_destino')->orWhere('tp_destino', 'conteudo');
            })
            ->where(function ($q) {
                $q->whereNull('descricao')->orWhere('descricao', '');
            })
            ->where(function ($q) {
                $q->whereNull('imagem')->orWhere('imagem', '');
            })
            ->count();
        if ($eventosSemConteudo > 0) {
            $alertas->push([
                'nivel' => 'info',
                'texto' => $eventosSemConteudo . ' evento(s) ativo(s) sem imagem e sem descrição.',
                'url' => url('gercont/eventos'),
            ]);
        }

        $oportunidadesVencendo = Oportunidade::where('fl_ativo', 1)
            ->whereNotNull('dt_validade')
            ->whereBetween('dt_validade', [$hoje->toDateString(), $limite30->toDateString()])
            ->count();
        if ($oportunidadesVencendo > 0) {
            $alertas->push([
                'nivel' => 'warning',
                'texto' => $oportunidadesVencendo . ' oportunidade(s) vencendo nos próximos 30 dias.',
                'url' => url('gercont/oportunidades'),
            ]);
        }

        $kpis = [
            [
                'label' => 'Eventos',
                'valor' => $eventosAtivos,
                'detalhe' => $eventosProximos30 . ' nos próximos 30 dias',
                'icone' => 'fa-calendar',
                'tom' => 'dash-tone-blue',
                'url' => url('gercont/eventos'),
            ],
            [
                'label' => 'Notícias',
                'valor' => $noticiasAtivas,
                'detalhe' => $noticiasMes . ' este mês · ' . $noticiasTotal . ' no total',
                'icone' => 'fa-newspaper-o',
                'tom' => 'dash-tone-green',
                'url' => url('gercont/noticias'),
            ],
            [
                'label' => 'Boletins',
                'valor' => $boletinsTotal,
                'detalhe' => $ultimoBoletim
                    ? 'Último em ' . Carbon::parse($ultimoBoletim->dt_publicacao)->format('d/m/Y')
                    : 'Nenhum publicado',
                'icone' => 'fa-files-o',
                'tom' => 'dash-tone-orange',
                'url' => url('gercont/boletins'),
            ],
            [
                'label' => 'Vídeos',
                'valor' => $videosAtivos,
                'detalhe' => $videosTotal . ' cadastrados',
                'icone' => 'fa-video-camera',
                'tom' => 'dash-tone-red',
                'url' => url('gercont/videos'),
            ],
            [
                'label' => 'Oportunidades',
                'valor' => $oportunidadesAbertas,
                'detalhe' => 'Ativas e dentro do prazo',
                'icone' => 'fa-briefcase',
                'tom' => 'dash-tone-teal',
                'url' => url('gercont/oportunidades'),
            ],
            [
                'label' => 'Páginas',
                'valor' => $paginasPublicadas,
                'detalhe' => $paginasTotal . ' no total',
                'icone' => 'fa-globe',
                'tom' => 'dash-tone-navy',
                'url' => url('gercont/paginas'),
            ],
        ];

        $atalhos = [
            ['label' => 'Eventos', 'url' => url('gercont/eventos'), 'icone' => 'fa-calendar', 'tom' => 'dash-tone-blue'],
            ['label' => 'Notícias', 'url' => url('gercont/noticias'), 'icone' => 'fa-newspaper-o', 'tom' => 'dash-tone-green'],
            ['label' => 'Boletins', 'url' => url('gercont/boletins'), 'icone' => 'fa-files-o', 'tom' => 'dash-tone-orange'],
            ['label' => 'Páginas', 'url' => url('gercont/paginas'), 'icone' => 'fa-globe', 'tom' => 'dash-tone-navy'],
            ['label' => 'Vídeos', 'url' => url('gercont/videos'), 'icone' => 'fa-video-camera', 'tom' => 'dash-tone-red'],
            ['label' => 'Oportunidades', 'url' => url('gercont/oportunidades'), 'icone' => 'fa-briefcase', 'tom' => 'dash-tone-teal'],
            ['label' => 'Publicações', 'url' => url('gercont/publicacoes'), 'icone' => 'fa-book', 'tom' => 'dash-tone-gray'],
            ['label' => 'Menus', 'url' => url('gercont/menus'), 'icone' => 'fa-list-ul', 'tom' => 'dash-tone-gray'],
        ];

        $usuarioNome = Auth::user() ? explode(' ', Auth::user()->name)[0] : 'Administrador';

        Carbon::setLocale('pt_BR');

        return view('gercont/index', compact(
            'kpis',
            'proximosEventos',
            'atividadeRecente',
            'alertas',
            'atalhos',
            'usuarioNome'
        ));
    }

    public function boletins()
    {
        Session::put('url', 'boletins');

        $boletins = Boletim::orderBy('dt_publicacao', 'desc')->get();

        return view('gercont/boletins', compact('boletins'));
    }

    public function eventos()
    {
        Session::put('url', 'eventos');

        $eventos = Evento::orderBy('data', 'desc')->get();

        return view('gercont/eventos', compact('eventos'));
    }

    public function menus()
    {
        Session::put('url', 'menus');

        $menus = array();

        return view('gercont/menus', compact('menus'));
    }

    public function noticias()
    {
        Session::put('url', 'noticias');

        $noticias = Noticia::orderBy('dt_noticia', 'desc')->get();

        return view('gercont/noticias', compact('noticias'));
    }

    public function paginas()
    {
        Session::put('url', 'paginas');

        $paginas = Pagina::orderBy('created_at', 'desc')->get();

        return view('gercont/paginas', compact('paginas'));
    }

    public function videos()
    {
        Session::put('url', 'videos');

        $videos = Video::orderBy('dt_video')->get();

        return view('gercont/videos', compact('videos'));
    }
}
