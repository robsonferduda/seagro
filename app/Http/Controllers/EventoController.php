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
        
        $eventos = Evento::all();

        return view('evento/index', compact('eventos'));
    }

    public function detalhes($id)
    {
        $evento = Evento::find($id);

        return view('evento/detalhes', compact('evento'));
    }
}