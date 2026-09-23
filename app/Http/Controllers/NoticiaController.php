<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    public function __construct()
    {
        
    }

    public function index(Request $request)
    {
        $busca = trim((string) $request->get('q', ''));
        $de = trim((string) $request->get('de', ''));
        $ate = trim((string) $request->get('ate', ''));
        $limite = 10;

        $dataDe = $this->parseDataFiltro($de);
        $dataAte = $this->parseDataFiltro($ate);
        $temFiltro = $busca !== '' || $dataDe || $dataAte;

        $query = Noticia::where('fl_ativa', 1)
            ->when($busca !== '', function ($q) use ($busca) {
                $q->where(function ($inner) use ($busca) {
                    $inner->where('titulo', 'like', '%' . $busca . '%')
                          ->orWhere('subtitulo', 'like', '%' . $busca . '%')
                          ->orWhere('corpo', 'like', '%' . $busca . '%');
                });
            })
            ->when($dataDe, function ($q) use ($dataDe) {
                $q->whereDate('dt_noticia', '>=', $dataDe);
            })
            ->when($dataAte, function ($q) use ($dataAte) {
                $q->whereDate('dt_noticia', '<=', $dataAte);
            })
            ->orderBy('dt_noticia', 'desc')
            ->orderBy('id', 'desc');

        $total = (clone $query)->count();
        $noticias = $query->limit($limite)->get();

        return view('noticia/index', compact('noticias', 'busca', 'de', 'ate', 'total', 'limite', 'temFiltro'));
    }

    private function parseDataFiltro(?string $valor): ?string
    {
        $valor = trim((string) $valor);
        if ($valor === '') {
            return null;
        }

        // YYYY-MM-DD (input type=date)
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $valor)) {
            return $valor;
        }

        // DD/MM/YYYY
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $valor)) {
            return implode('-', array_reverse(explode('/', $valor)));
        }

        return null;
    }

    public function destaque($pagina)
    {

        if($pagina == 'boletim')
            return view('destaque/boletim');


        return view('home');
    }

    public function buscar($url)
    {
        $noticia = Noticia::where('url', $url)->first();
        $noticia->num_visitas = $noticia->num_visitas + 1;
        $noticia->save();
        
        return view('noticia/conteudo', compact('noticia'));
    }
}