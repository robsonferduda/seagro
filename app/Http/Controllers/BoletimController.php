<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Boletim;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Http\Requests\BoletimRequest;
use App\Http\Requests\BoletimUpdateRequest;
use Illuminate\Support\Facades\Session;

class BoletimController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        Session::put('url','boletins');
    }

    public function index()
    {
        $dados = Boletim::orderBy('dt_publicacao','desc')->get();

        return view('boletim/index', compact('dados'));
    }

    public function atualizar($id)
    {
        $boletim = Boletim::find($id);
        $boletim->fl_publicacao = !$boletim->fl_publicacao;
        $boletim->save();

        Flash::success('<i class="fa fa-check"></i> Informações de publicação atualizadas com sucesso');
        return redirect('gercont/boletins')->withInput();
    }

    public function show(Boletim $boletim)
    {
        return view('boletim/detalhes', compact('boletim'));
    }

    public function create()
    {
        return view('boletim/create');
    }

    public function store(BoletimRequest $request)
    {
        $imagem = $request->file('imagem');
        $pdf = $request->file('pdf');
        $audio = $request->file('audio');

        $data = implode('-', array_reverse(explode('/', $request->dt_publicacao)));

        $nome_arquivo = 'boletim-'.$data;

        $arquivo_imagem = $nome_arquivo.'.'.$imagem->getClientOriginalExtension();
        $arquivo_pdf = $nome_arquivo.'.'.$pdf->getClientOriginalExtension();
        $arquivo_audio = null;

        // Salvar arquivos diretamente na pasta boletim
        $request->file('pdf')->storeAs('', $arquivo_pdf, 'boletim');
        $request->file('imagem')->storeAs('', $arquivo_imagem, 'boletim');
        
        if ($audio) {
            $arquivo_audio = $nome_arquivo.'.'.$audio->getClientOriginalExtension();
            $request->file('audio')->storeAs('', $arquivo_audio, 'boletim');
        }

        // Criar boletim para obter o ID
        $boletim = Boletim::create([
            'titulo' => $request->titulo,
            'subtitulo' => $request->subtitulo,
            'dt_publicacao' => $data,
            'arquivo' => $arquivo_pdf,
            'imagem' => $arquivo_imagem,
            'audio' => $arquivo_audio,
            'fl_publicacao' => $request->has('fl_publicacao') ? 1 : 0,
            'acessos' => 0,
            'downloads' => 0
        ]);

        // Gerar o campo texto automaticamente
        $texto = '<p><a href="'.url('boletim/download/'.$boletim->id).'" class="forum-item-title">Clique aqui para baixar</a></p>'."\n";
        $texto .= '<p><img src="'.url('boletim/'.$arquivo_imagem).'" width="100%"  alt=""></p>';

        // Atualizar com o texto gerado
        $boletim->texto = $texto;
        $boletim->save();

        Flash::success('<i class="fa fa-check"></i> Boletim cadastrado com sucesso');

        return redirect('gercont/boletins')->withInput();
    }

    public function edit(Boletim $boletim)
    {
        return view('boletim/edit', compact('boletim'));
    }

    public function update(BoletimUpdateRequest $request, $id)
    {
        $boletim = Boletim::findOrFail($id);
        
        $data = implode('-', array_reverse(explode('/', $request->dt_publicacao)));
        $nome_arquivo = 'boletim-'.$data;

        // Atualizar PDF se enviado
        if ($request->hasFile('pdf')) {
            // Excluir arquivo antigo se existir
            if ($boletim->arquivo && file_exists(public_path('boletim/'.$boletim->arquivo))) {
                unlink(public_path('boletim/'.$boletim->arquivo));
            }
            
            $pdf = $request->file('pdf');
            $arquivo_pdf = $nome_arquivo.'.'.$pdf->getClientOriginalExtension();
            $pdf->storeAs('', $arquivo_pdf, 'boletim');
            $boletim->arquivo = $arquivo_pdf;
        }

        // Atualizar Imagem se enviada
        $imagem_atualizada = false;
        if ($request->hasFile('imagem')) {
            // Excluir arquivo antigo se existir
            if ($boletim->imagem && file_exists(public_path('boletim/'.$boletim->imagem))) {
                unlink(public_path('boletim/'.$boletim->imagem));
            }
            
            $imagem = $request->file('imagem');
            $arquivo_imagem = $nome_arquivo.'.'.$imagem->getClientOriginalExtension();
            $imagem->storeAs('', $arquivo_imagem, 'boletim');
            $boletim->imagem = $arquivo_imagem;
            $imagem_atualizada = true;
        }

        // Atualizar Áudio se enviado
        if ($request->hasFile('audio')) {
            // Excluir arquivo antigo se existir
            if ($boletim->audio && file_exists(public_path('boletim/'.$boletim->audio))) {
                unlink(public_path('boletim/'.$boletim->audio));
            }
            
            $audio = $request->file('audio');
            $arquivo_audio = $nome_arquivo.'.'.$audio->getClientOriginalExtension();
            $audio->storeAs('', $arquivo_audio, 'boletim');
            $boletim->audio = $arquivo_audio;
        }

        // Atualizar campos básicos
        $boletim->titulo = $request->titulo;
        $boletim->subtitulo = $request->subtitulo;
        $boletim->dt_publicacao = $data;
        $boletim->fl_publicacao = $request->has('fl_publicacao') ? 1 : 0;

        // Regenerar o campo texto se a imagem foi atualizada
        if ($imagem_atualizada) {
            $texto = '<p><a href="'.url('boletim/download/'.$boletim->id).'" class="forum-item-title">Clique aqui para baixar</a></p>'."\n";
            $texto .= '<p><img src="'.url('boletim/'.$boletim->imagem).'" width="100%"  alt=""></p>';
            $boletim->texto = $texto;
        }

        $boletim->save();

        Flash::success('<i class="fa fa-check"></i> Boletim atualizado com sucesso');

        return redirect('gercont/boletins');
    }

    public function destroy($id)
    {
        $boletim = Boletim::findOrFail($id);

        // Excluir arquivos físicos
        if ($boletim->arquivo && file_exists(public_path('boletim/'.$boletim->arquivo))) {
            unlink(public_path('boletim/'.$boletim->arquivo));
        }

        if ($boletim->imagem && file_exists(public_path('boletim/'.$boletim->imagem))) {
            unlink(public_path('boletim/'.$boletim->imagem));
        }

        if ($boletim->audio && file_exists(public_path('boletim/'.$boletim->audio))) {
            unlink(public_path('boletim/'.$boletim->audio));
        }

        // Excluir registro do banco
        $boletim->delete();

        Flash::success('<i class="fa fa-check"></i> Boletim excluído com sucesso');

        return redirect('gercont/boletins');
    }
}