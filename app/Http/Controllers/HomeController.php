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
        $eventos = Evento::with('tipo')->where('fl_ativo', 1)->orderBy('data','DESC')->take(5)->get();
        $noticias = Noticia::where("fl_ativa", 1)->where("fl_banner", 1)->orderBy('dt_noticia','DESC')->get();
        $videos = Video::where('fl_ativo', 1)->orderBy('dt_video','DESC')->orderBy('created_at','DESC')->take(3)->get();
        $noticias_extra = Noticia::where("fl_ativa", 1)->where("fl_banner", 0)->orderBy('dt_noticia','DESC')->get();

        $comCapa = function ($noticia) {
            return !empty($noticia->img_capa);
        };
        $carrossel = $noticias->filter($comCapa)->values();
        if ($carrossel->count() < 7) {
            $carrossel = $carrossel->concat($noticias_extra->filter($comCapa)->take(7 - $carrossel->count()));
        }
        $carrossel = $carrossel->take(7)->values();

        $dados_acesso = array('pagina' => 'home');
        
        Estatistica::create($dados_acesso);

        return view('home', compact('noticias','eventos','noticias_extra','videos','carrossel'));
    }
}