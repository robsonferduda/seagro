<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Evento;
use App\Models\Video;
use App\Models\Boletim;
use App\Models\Noticia;
use App\Models\Pagina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ConteudoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Session::put('url','gercont');

        $boletins = Boletim::orderBy('created_at','DESC')->get();
        $paginas = Pagina::orderBy('created_at','DESC')->get();
        $videos = Video::where('fl_ativo', 1)->orderBy('dt_video')->get();
        $noticias = Noticia::where("fl_ativa", 1)->where("fl_banner", 1)->orderBy('dt_noticia','DESC')->get();

        return view('gercont/index', compact('boletins','paginas','noticias','videos'));
    }

    public function boletins()
    {
        Session::put('url','boletins');

        $boletins = Boletim::orderBy('dt_publicacao','desc')->get();

        return view('gercont/boletins', compact('boletins'));
    }

    public function eventos()
    {
        Session::put('url','eventos');

        $eventos = Evento::orderBy('data','desc')->get();

        return view('gercont/eventos', compact('eventos'));
    }

    public function menus()
    {
        Session::put('url','menus');

        $menus = array();

        return view('gercont/menus', compact('menus'));
    }

    public function noticias()
    {
        Session::put('url','noticias');

        $noticias = Noticia::orderBy('dt_noticia','desc')->get();

        return view('gercont/noticias', compact('noticias'));
    }

    public function paginas()
    {
        Session::put('url','paginas');

        $paginas = Pagina::orderBy('created_at','desc')->get();

        return view('gercont/paginas', compact('paginas'));
    }

    public function videos()
    {
        Session::put('url','videos');

        $videos = Video::orderBy('dt_video')->get();

        return view('gercont/videos', compact('videos'));
    }

    
}