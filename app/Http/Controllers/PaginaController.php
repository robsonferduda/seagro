<?php

namespace App\Http\Controllers;

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

    public function destaque()
    {
        return view('home');
    }
}