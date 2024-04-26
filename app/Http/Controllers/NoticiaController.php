<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $noticias = Noticia::where("fl_ativa", 1)->orderBy('dt_noticia','DESC')->get();

        return view('noticia/index', compact('noticias'));
    }

    public function destaque($pagina)
    {

        if($pagina == 'boletim')
            return view('destaque/boletim');


        return view('home');
    }

    public function buscar($url)
    {
        $noticia = Noticia::where('url', $url)->first();
        $noticia->num_visitas = $noticia->num_visitas + 1;
        $noticia->save();
        
        return view('noticia/conteudo', compact('noticia'));
    }
}