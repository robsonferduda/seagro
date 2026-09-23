<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    public function __construct()
    {
        
    }

    public function index(Request $request)
    {
        $busca = trim((string) $request->get('q', ''));
        $limite = 10;

        $query = Noticia::where('fl_ativa', 1)
            ->when($busca !== '', function ($q) use ($busca) {
                $q->where(function ($inner) use ($busca) {
                    $inner->where('titulo', 'like', '%' . $busca . '%')
                          ->orWhere('subtitulo', 'like', '%' . $busca . '%')
                          ->orWhere('corpo', 'like', '%' . $busca . '%');
                });
            })
            ->orderBy('dt_noticia', 'desc')
            ->orderBy('id', 'desc');

        $total = (clone $query)->count();
        $noticias = $query->limit($limite)->get();

        return view('noticia/index', compact('noticias', 'busca', 'total', 'limite'));
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