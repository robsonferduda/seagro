<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\TipoEvento;
use Illuminate\Http\Request;
use App\Http\Requests\EventoRequest;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class EventoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detalhes']);
    }

    public function index(Request $request)
    {
        $busca = trim((string) $request->get('q', ''));

        $eventos = Evento::with('tipo')
            ->where('fl_ativo', 1)
            ->when($busca !== '', function ($query) use ($busca) {
                $query->where(function ($q) use ($busca) {
                    $q->where('titulo', 'like', '%' . $busca . '%')
                      ->orWhere('descricao', 'like', '%' . $busca . '%');
                });
            })
            ->orderBy('data', 'DESC')
            ->get();

        return view('evento/index', compact('eventos', 'busca'));
    }

    public function detalhes($apelido)
    {
        $evento = Evento::with('tipo')->where('apelido', $apelido)->where('fl_ativo', 1)->firstOrFail();

        if ($evento->isRedirect()) {
            $url = $evento->url_destino;

            if (strpos($url, '/') === 0) {
                return redirect($url);
            }

            return redirect()->away($url);
        }

        return view('evento/detalhes', compact('evento'));
    }

    public function create()
    {
        $tipos = TipoEvento::all();
        return view('evento/create', compact('tipos'));
    }

    public function store(EventoRequest $request)
    {
        $data = implode('-', array_reverse(explode('/', $request->data)));
        
        // Gerar apelido/slug automaticamente a partir do título e data
        $slugBase = Str::slug($request->titulo);
        $apelido = $slugBase . '-' . $data;
        
        // Verificar se já existe e adicionar sufixo se necessário
        $count = 1;
        $apelidoOriginal = $apelido;
        while (Evento::where('apelido', $apelido)->exists()) {
            $apelido = $apelidoOriginal . '-' . $count;
            $count++;
        }
        
        $tpDestino = $request->tp_destino === 'redirect' ? 'redirect' : 'conteudo';

        $dados = [
            'id_tipo' => $request->id_tipo,
            'data' => $data,
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'tp_destino' => $tpDestino,
            'url_destino' => $tpDestino === 'redirect' ? $request->url_destino : null,
            'fl_nova_aba' => $tpDestino === 'redirect' && $request->boolean('fl_nova_aba') ? 1 : 0,
            'apelido' => $apelido,
            'fl_ativo' => $request->has('fl_ativo') ? 1 : 0
        ];

        // Upload de imagem se enviada
        if ($request->hasFile('imagem')) {
            $imagem = $request->file('imagem');
            $nomeArquivo = $apelido . '.' . $imagem->getClientOriginalExtension();
            $imagem->move(public_path('img/eventos'), $nomeArquivo);
            $dados['imagem'] = $nomeArquivo;
        }

        Evento::create($dados);

        Flash::success('<i class="fa fa-check"></i> Evento cadastrado com sucesso');

        return redirect('gercont/eventos');
    }

    public function edit(Evento $evento)
    {
        $tipos = TipoEvento::all();
        return view('evento/edit', compact('evento', 'tipos'));
    }

    public function update(EventoRequest $request, $id)
    {
        $evento = Evento::findOrFail($id);
        
        $data = implode('-', array_reverse(explode('/', $request->data)));
        
        // Gerar novo apelido/slug a partir do título e data
        $slugBase = Str::slug($request->titulo);
        $apelido = $slugBase . '-' . $data;
        
        // Verificar se já existe (exceto o próprio evento) e adicionar sufixo se necessário
        $count = 1;
        $apelidoOriginal = $apelido;
        while (Evento::where('apelido', $apelido)->where('id', '!=', $id)->exists()) {
            $apelido = $apelidoOriginal . '-' . $count;
            $count++;
        }
        
        $tpDestino = $request->tp_destino === 'redirect' ? 'redirect' : 'conteudo';

        $evento->id_tipo = $request->id_tipo;
        $evento->data = $data;
        $evento->titulo = $request->titulo;
        $evento->tp_destino = $tpDestino;
        $evento->descricao = $request->descricao;
        $evento->url_destino = $tpDestino === 'redirect' ? $request->url_destino : null;
        $evento->fl_nova_aba = $tpDestino === 'redirect' && $request->boolean('fl_nova_aba') ? 1 : 0;
        $evento->apelido = $apelido;
        $evento->fl_ativo = $request->has('fl_ativo') ? 1 : 0;

        // Upload de imagem se enviada
        if ($request->hasFile('imagem')) {
            // Excluir imagem antiga se existir
            if ($evento->imagem && file_exists(public_path('img/eventos/'.$evento->imagem))) {
                unlink(public_path('img/eventos/'.$evento->imagem));
            }
            
            $imagem = $request->file('imagem');
            $nomeArquivo = $apelido . '.' . $imagem->getClientOriginalExtension();
            $imagem->move(public_path('img/eventos'), $nomeArquivo);
            $evento->imagem = $nomeArquivo;
        }

        $evento->save();

        Flash::success('<i class="fa fa-check"></i> Evento atualizado com sucesso');

        return redirect('gercont/eventos');
    }

    public function atualizar($id)
    {
        $evento = Evento::find($id);
        $evento->fl_ativo = !$evento->fl_ativo;
        $evento->save();

        Flash::success('<i class="fa fa-check"></i> Status do evento atualizado com sucesso');
        return redirect('gercont/eventos');
    }

    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);

        // Excluir imagem se existir
        if ($evento->imagem && file_exists(public_path('img/eventos/'.$evento->imagem))) {
            unlink(public_path('img/eventos/'.$evento->imagem));
        }

        // Excluir registro do banco
        $evento->delete();

        Flash::success('<i class="fa fa-check"></i> Evento excluído com sucesso');

        return redirect('gercont/eventos');
    }
}