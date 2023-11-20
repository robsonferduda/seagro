<?php

namespace App\Http\Controllers;

use App\Models\Pagina;
use Illuminate\Http\Request;

class PaginaController extends Controller
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

    public function evento()
    {
        return view('eventos');
    }

    public function buscar($pagina)
    {
        $pagina = Pagina::where('apelido', $pagina)->first();
        return view('paginas/conteudo', compact('pagina'));
    }
}