<?php

namespace App\Http\Controllers;

use App\Models\Oportunidade;
use Illuminate\Http\Request;
use App\Http\Requests\OportunidadeRequest;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Session;

class OportunidadeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    // Listagem pública
    public function index()
    {
        $oportunidades = Oportunidade::ativas()
                                    ->orderBy('dt_publicacao', 'desc')
                                    ->get();

        return view('oportunidades/index', compact('oportunidades'));
    }

    // Visualizar oportunidade pública
    public function show($id)
    {
        $oportunidade = Oportunidade::where('fl_ativo', 1)->findOrFail($id);
        
        // Incrementar visualizações
        $oportunidade->visualizacoes = $oportunidade->visualizacoes + 1;
        $oportunidade->save();

        return view('oportunidades/detalhes', compact('oportunidade'));
    }

    // Listagem administrativa
    public function lista()
    {
        Session::put('url', 'oportunidades');
        $oportunidades = Oportunidade::orderBy('dt_publicacao', 'desc')->get();

        return view('gercont/oportunidades', compact('oportunidades'));
    }

    public function create()
    {
        return view('oportunidades/create');
    }

    public function store(OportunidadeRequest $request)
    {
        $dt_publicacao = implode('-', array_reverse(explode('/', $request->dt_publicacao)));
        $dt_validade = null;
        
        if ($request->dt_validade) {
            $dt_validade = implode('-', array_reverse(explode('/', $request->dt_validade)));
        }

        $dados = [
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'empresa' => $request->empresa,
            'tipo' => $request->tipo,
            'localizacao' => $request->localizacao,
            'salario' => $request->salario,
            'dt_publicacao' => $dt_publicacao,
            'dt_validade' => $dt_validade,
            'link_externo' => $request->link_externo,
            'fl_ativo' => $request->has('fl_ativo') ? 1 : 0,
            'visualizacoes' => 0
        ];

        // Upload de arquivo se enviado
        if ($request->hasFile('arquivo')) {
            $arquivo = $request->file('arquivo');
            $nomeArquivo = 'oportunidade-' . time() . '.' . $arquivo->getClientOriginalExtension();
            $arquivo->move(public_path('oportunidades'), $nomeArquivo);
            $dados['arquivo'] = $nomeArquivo;
        }

        Oportunidade::create($dados);

        Flash::success('<i class="fa fa-check"></i> Oportunidade cadastrada com sucesso');

        return redirect('gercont/oportunidades');
    }

    public function edit(Oportunidade $oportunidade)
    {
        return view('oportunidades/edit', compact('oportunidade'));
    }

    public function update(OportunidadeRequest $request, $id)
    {
        $oportunidade = Oportunidade::findOrFail($id);
        
        $dt_publicacao = implode('-', array_reverse(explode('/', $request->dt_publicacao)));
        $dt_validade = null;
        
        if ($request->dt_validade) {
            $dt_validade = implode('-', array_reverse(explode('/', $request->dt_validade)));
        }

        $oportunidade->titulo = $request->titulo;
        $oportunidade->descricao = $request->descricao;
        $oportunidade->empresa = $request->empresa;
        $oportunidade->tipo = $request->tipo;
        $oportunidade->localizacao = $request->localizacao;
        $oportunidade->salario = $request->salario;
        $oportunidade->dt_publicacao = $dt_publicacao;
        $oportunidade->dt_validade = $dt_validade;
        $oportunidade->link_externo = $request->link_externo;
        $oportunidade->fl_ativo = $request->has('fl_ativo') ? 1 : 0;

        // Upload de arquivo se enviado
        if ($request->hasFile('arquivo')) {
            // Excluir arquivo antigo se existir
            if ($oportunidade->arquivo && file_exists(public_path('oportunidades/'.$oportunidade->arquivo))) {
                unlink(public_path('oportunidades/'.$oportunidade->arquivo));
            }
            
            $arquivo = $request->file('arquivo');
            $nomeArquivo = 'oportunidade-' . time() . '.' . $arquivo->getClientOriginalExtension();
            $arquivo->move(public_path('oportunidades'), $nomeArquivo);
            $oportunidade->arquivo = $nomeArquivo;
        }

        $oportunidade->save();

        Flash::success('<i class="fa fa-check"></i> Oportunidade atualizada com sucesso');

        return redirect('gercont/oportunidades');
    }

    public function atualizar($id)
    {
        $oportunidade = Oportunidade::find($id);
        $oportunidade->fl_ativo = !$oportunidade->fl_ativo;
        $oportunidade->save();

        Flash::success('<i class="fa fa-check"></i> Status da oportunidade atualizado com sucesso');
        return redirect('gercont/oportunidades');
    }

    public function destroy($id)
    {
        $oportunidade = Oportunidade::findOrFail($id);

        // Excluir arquivo se existir
        if ($oportunidade->arquivo && file_exists(public_path('oportunidades/'.$oportunidade->arquivo))) {
            unlink(public_path('oportunidades/'.$oportunidade->arquivo));
        }

        $oportunidade->delete();

        Flash::success('<i class="fa fa-check"></i> Oportunidade excluída com sucesso');

        return redirect('gercont/oportunidades');
    }
}