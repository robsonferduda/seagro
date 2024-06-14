<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Evento;
use App\Models\Noticia;
use App\Models\Estatistica;
use Illuminate\Http\Request;

class ConteudoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        dd(Auth::user());
    }
}