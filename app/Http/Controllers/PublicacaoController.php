<?php

namespace App\Http\Controllers;

use App\Models\Publicacao;
use App\Models\Pagina;
use App\Models\Estatistica;
use Illuminate\Http\Request;
use App\Http\Requests\PublicacaoRequest;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PublicacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index()
    {
        $pagina = Pagina::where('apelido', 'publicacoes')->first();
        $publicacoes = Publicacao::ativas()
            ->orderBy('nu_ordem')
            ->orderBy('titulo')
            ->get();

        if ($pagina) {
            $pagina->nu_visualizacoes = $pagina->nu_visualizacoes + 1;
            $pagina->save();
            Estatistica::create(['pagina' => 'publicacoes']);
        }

        return view('publicacoes/index', compact('publicacoes', 'pagina'));
    }

    public function lista()
    {
        Session::put('url', 'publicacoes');
        $publicacoes = Publicacao::orderBy('nu_ordem')->orderBy('titulo')->get();

        return view('gercont/publicacoes', compact('publicacoes'));
    }

    public function create()
    {
        return view('publicacoes/create');
    }

    public function store(PublicacaoRequest $request)
    {
        $dados = [
            'titulo' => $request->titulo,
            'subtitulo' => $request->subtitulo,
            'link_externo' => $request->link_externo,
            'nu_ordem' => (int) ($request->nu_ordem ?: 0),
            'fl_ativo' => $request->has('fl_ativo') ? 1 : 0,
        ];

        if ($request->hasFile('arquivo')) {
            $arquivo = $request->file('arquivo');
            $nome = Str::slug(pathinfo($arquivo->getClientOriginalName(), PATHINFO_FILENAME));
            $nomeArquivo = $nome . '-' . time() . '.' . $arquivo->getClientOriginalExtension();
            $arquivo->move(public_path('publicacoes'), $nomeArquivo);
            $dados['arquivo'] = 'publicacoes/' . $nomeArquivo;
            $dados['link_externo'] = null;
        }

        Publicacao::create($dados);

        Flash::success('<i class="fa fa-check"></i> Publicação cadastrada com sucesso');

        return redirect('gercont/publicacoes');
    }

    public function edit(Publicacao $publicacao)
    {
        return view('publicacoes/edit', compact('publicacao'));
    }

    public function update(PublicacaoRequest $request, $id)
    {
        $publicacao = Publicacao::findOrFail($id);

        $publicacao->titulo = $request->titulo;
        $publicacao->subtitulo = $request->subtitulo;
        $publicacao->nu_ordem = (int) ($request->nu_ordem ?: 0);
        $publicacao->fl_ativo = $request->has('fl_ativo') ? 1 : 0;
        $publicacao->link_externo = $request->link_externo;

        if ($request->hasFile('arquivo')) {
            if ($publicacao->arquivo && $publicacao->temArquivoLocal() && strpos($publicacao->arquivo, 'publicacoes/') === 0) {
                $nome = basename($publicacao->arquivo);
                if (preg_match('/-\d+\./', $nome) && file_exists(public_path($publicacao->arquivo))) {
                    @unlink(public_path($publicacao->arquivo));
                }
            }

            $arquivo = $request->file('arquivo');
            $nome = Str::slug(pathinfo($arquivo->getClientOriginalName(), PATHINFO_FILENAME));
            $nomeArquivo = $nome . '-' . time() . '.' . $arquivo->getClientOriginalExtension();
            $arquivo->move(public_path('publicacoes'), $nomeArquivo);
            $publicacao->arquivo = 'publicacoes/' . $nomeArquivo;
            $publicacao->link_externo = null;
        }

        $publicacao->save();

        Flash::success('<i class="fa fa-check"></i> Publicação atualizada com sucesso');

        return redirect('gercont/publicacoes');
    }

    public function atualizar($id)
    {
        $publicacao = Publicacao::findOrFail($id);
        $publicacao->fl_ativo = !$publicacao->fl_ativo;
        $publicacao->save();

        Flash::success('<i class="fa fa-check"></i> Status da publicação atualizado com sucesso');

        return redirect('gercont/publicacoes');
    }

    public function destroy($id)
    {
        $publicacao = Publicacao::findOrFail($id);

        if ($publicacao->arquivo && $publicacao->temArquivoLocal() && strpos($publicacao->arquivo, 'publicacoes/') === 0) {
            // só remove arquivos novos da pasta publicacoes/, preserva documentos históricos
            $nome = basename($publicacao->arquivo);
            if (preg_match('/-\d+\./', $nome) && file_exists(public_path($publicacao->arquivo))) {
                @unlink(public_path($publicacao->arquivo));
            }
        }

        $publicacao->delete();

        Flash::success('<i class="fa fa-check"></i> Publicação excluída com sucesso');

        return redirect('gercont/publicacoes');
    }
}
