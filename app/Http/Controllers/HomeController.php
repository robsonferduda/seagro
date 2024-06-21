<?php

namespace App\Http\Controllers;

use App\Models\Video;
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
        $noticias = Noticia::where("fl_ativa", 1)->where("fl_banner", 1)->orderBy('dt_noticia','DESC')->get();
        $videos = Video::where('fl_ativo', 1)->orderBy('dt_video')->take(3)->get();
        $noticias_extra = Noticia::where("fl_ativa", 1)->where("fl_banner", 0)->orderBy('dt_noticia','DESC')->get();

        $dados_acesso = array('pagina' => 'home');
        
        Estatistica::create($dados_acesso);

        return view('home', compact('noticias','eventos','noticias_extra','videos'));
    }
}