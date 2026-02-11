<?php

namespace App\Http\Controllers;

use App\Models\Boletim;
use App\Models\Evento;
use App\Models\Pagina;
use App\Models\Estatistica;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OportunidadeController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $$oportunidades = null;

        return view('oportunidades/index',compact('oportunidades'));
    }
}