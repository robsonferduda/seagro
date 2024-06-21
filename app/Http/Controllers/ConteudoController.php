<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Video;
use App\Models\Boletim;
use App\Models\Noticia;
use App\Models\Pagina;
use Illuminate\Http\Request;

class ConteudoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $boletins = Boletim::orderBy('created_at','DESC')->get();
        $paginas = Pagina::orderBy('created_at','DESC')->get();
        $videos = Video::where('fl_ativo', 1)->orderBy('dt_video')->get();
        $noticias = Noticia::where("fl_ativa", 1)->where("fl_banner", 1)->orderBy('dt_noticia','DESC')->get();

        return view('gercont/index', compact('boletins','paginas','noticias','videos'));
    }

    public function videos()
    {
        $videos = Video::orderBy('dt_video')->get();

        return view('gercont/videos', compact('videos'));
    }

    public function boletins()
    {
        $boletins = Boletim::orderBy('dt_publicacao','desc')->get();

        return view('gercont/boletins', compact('boletins'));
    }
}