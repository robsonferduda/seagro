<?php

namespace App\Http\Controllers;

use App\Models\Boletim;
use App\Models\Evento;
use App\Models\Pagina;
use App\Models\Estatistica;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaginaController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $eventos = Evento::all();

        return view('home',compact('eventos'));
    }

    public function destaque($pagina)
    {

        switch ($pagina) {
            case 'boletim':
                $boletins = Boletim::orderBy('dt_publicacao','desc')->get();
                return view('destaque/boletim',compact('boletins'));
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

        $dados_acesso = array('pagina' => $pagina->apelido);
        
        Estatistica::create($dados_acesso);
        
        return view('paginas/conteudo', compact('pagina'));
    }

    public function contato()
    {        
        return view('formulario');
    } 
    
    public function getBoletim($data)
    {        
        $boletim = Boletim::where('dt_publicacao', $data)->first();
        $boletim->acessos = $boletim->acessos + 1;
        $boletim->save();

        return view('boletim/detalhes', compact('boletim'));
    }
    
    public function boletim($id)
    {        
        $boletim = Boletim::find($id);
        $boletim->downloads = $boletim->downloads + 1;
        $boletim->save();

        $file = public_path()."/boletim/".$boletim->arquivo;

        $headers = array('Content-Type: application/pdf',);

        return response()->download($file, $boletim->arquivo, $headers);
    }
}