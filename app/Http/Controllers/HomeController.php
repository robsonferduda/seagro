<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $noticias = Noticia::where("fl_ativa", 1)->get();
        return view('home', compact('noticias'));
    }
}