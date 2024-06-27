<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Boletim;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Http\Requests\BoletimRequest;
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
        $arquivo_audio = $nome_arquivo.'.'.$audio->getClientOriginalExtension();

        $request->file('pdf')->storeAs('pdf', $arquivo_pdf, 'boletim');
        $request->file('imagem')->storeAs('img', $arquivo_imagem, 'boletim');
        $request->file('audio')->storeAs('audio', $arquivo_audio, 'boletim');

        $dados = array('titulo' => $request->titulo,
                       'dt_publicacao' => $data);

        Boletim::create($dados);

        Flash::success('<i class="fa fa-check"></i> Informações de publicação atualizadas com sucesso');

        return redirect('gercont/boletins')->withInput();
    }
}