<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Noticia;
use App\Models\Estatistica;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $eventos = Evento::where('fl_ativo', 1)->orderBy('data','DESC')->get();
        $noticias = Noticia::where("fl_ativa", 1)->get();

        $dados_acesso = array('pagina' => 'home');
        
        Estatistica::create($dados_acesso);

        return view('home', compact('noticias','eventos'));
    }
}