<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Evento;
use App\Models\Pagina;
use App\Models\Estatistica;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VideoController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $videos = Video::where('fl_ativo', 1)->orderBy('dt_video')->get();

        return view('video/index',compact('videos'));
    }

    public function destaque($pagina)
    {

        switch ($pagina) {
            case 'boletim':
                $boletins = Boletim::where('fl_publicacao', 1)->orderBy('dt_publicacao','desc')->get();
                return view('destaque/boletim',compact('boletins'));
                break;

            case 'contribuicao-sindical':
                return view('destaque/contribuicao');
                break;

            case 'linha_do_tempo':
                return view('destaque/linha_tempo');
                break;
            
            default:
                return view('home');
                break;
        }

    }
}