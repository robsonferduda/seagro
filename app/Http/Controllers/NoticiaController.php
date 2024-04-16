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
        

        return view('home');
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
        
        return view('noticia/conteudo', compact('noticia'));
    }
}