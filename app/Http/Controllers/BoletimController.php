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

        dd($pdf);

        Flash::success('<i class="fa fa-check"></i> Informações de publicação atualizadas com sucesso');

        return redirect('gercont/boletins')->withInput();
    }
}