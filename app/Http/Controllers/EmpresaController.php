<?php

namespace App\Http\Controllers;

use App\Models\Boletim;
use App\Models\Evento;
use App\Models\Pagina;
use App\Models\Estatistica;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmpresaController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $eventos = Evento::all();

        return view('home',compact('eventos'));
    }

    public function publicas($pagina)
    {

        switch ($pagina) {
            case 'pautas':
                $pagina = "Pautas de Reivindicações";                
                break;

            case 'editais-de-convocacao':
                $pagina = "Editais de Convocação"; 
                break;

            case 'diversos':
                $pagina = "Diversos"; 
                break;
            
            default:
                return view('home');
                break;
        }
        return view('empresas/publicas',compact('pagina'));
    }

    public function privadas($pagina)
    {

        switch ($pagina) {
            case 'cooperativas':
                $pagina = "Cooperativas";                
                break;

            case 'agroindustrias':
                $pagina = "Agroindústrias"; 
                break;

            case 'crea-sc':
                $pagina = "CREA-SC"; 
                break;
            
            default:
                return view('home');
                break;
        }
        return view('empresas/privadas',compact('pagina'));
    }
}