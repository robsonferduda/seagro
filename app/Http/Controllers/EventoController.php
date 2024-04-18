<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {        
        $eventos = Evento::orderBy('data','DESC')->get();

        return view('evento/index', compact('eventos'));
    }

    public function detalhes($apelido)
    {
        $evento = Evento::where('apelido', $apelido)->first();

        return view('evento/detalhes', compact('evento'));
    }
}