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

        switch ($pagina) {
            case 'boletim':
                return view('destaque/boletim');
                break;

            case 'contribuicao-sindical':
                return view('destaque/contribuicao');
                break;
            
            default:
                return view('home');
                break;
        }

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