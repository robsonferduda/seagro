<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Utils;
use App\Models\Video;
use App\Models\Evento;
use App\Models\Pagina;
use App\Models\Estatistica;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VideoController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $videos = Video::where('fl_ativo', 1)->orderBy('dt_video')->get();

        return view('video/index',compact('videos'));
    }

    public function atualizar($id)
    {
        $video = Video::where('id', $id)->first();
        $video->fl_ativo = !$video->fl_ativo;
        $video->save();

        return redirect('gercont/videos')->withInput();
    }

    public function show($id)
    {
        $video = Video::where('id', $id)->first();
        return view('video/detalhes',compact('video'));
    }

    public function create()
    {
        return view('video/create');
    }   
    
    public function edit(Video $video)
    {
        return view('video/editar', compact('video'));
    } 

    public function destaque($pagina)
    {

        switch ($pagina) {
            case 'boletim':
                $boletins = Boletim::where('fl_publicacao', 1)->orderBy('dt_publicacao','desc')->get();
                return view('destaque/boletim',compact('boletins'));
                break;

            case 'contribuicao-sindical':
                return view('destaque/contribuicao');
                break;

            case 'linha_do_tempo':
                return view('destaque/linha_tempo');
                break;
            
            default:
                return view('home');
                break;
        }

    }

    public function store(Request $request)
    {
        try {
            Video::create($request->all());

            $retorno = array('flag' => true,
                             'msg' => '<i class="fa fa-check"></i> Dados inseridos com sucesso');

        } catch (\Illuminate\Database\QueryException $e) {

            $retorno = array('flag' => false,
                             'msg' => Utils::getDatabaseMessageByCode($e->getCode()));

        } catch (\Exception $e) {
            $retorno = array('flag' => true,
                             'msg' => '<i class="fa fa-times"></i> Ocorreu um erro ao inserir o registro');
        }

        if ($retorno['flag']) {
            Flash::success($retorno['msg']);
            return redirect('gercont/videos')->withInput();
        } else {
            Flash::error($retorno['msg']);
            return redirect('video/create')->withInput();
        }
    }

    public function update(Request $request, Video $video)
    {
        try {
            $flag = $request->fl_ativo == true ? true : false;
            $video->nm_video = $request->nm_video;
            $video->url = $request->url;
            $video->dt_video = implode('-', array_reverse(explode('/', $request->dt_video)));
            $video->fl_ativo = $flag;

            $video->save();

            $retorno = array('flag' => true,
                             'msg' => '<i class="fa fa-check"></i> Dados atualizados com sucesso');

        } catch (\Illuminate\Database\QueryException $e) {

            $retorno = array('flag' => false,
                             'msg' => Utils::getDatabaseMessageByCode($e->getCode()));

        } catch (\Exception $e) {

            dd($e);
            $retorno = array('flag' => false,
                             'msg' => '<i class="fa fa-times"></i> Ocorreu um atualizar dados');
        }

        if ($retorno['flag']) {
            Flash::success($retorno['msg']);
            return redirect('gercont/videos')->withInput();
        } else {
            Flash::error($retorno['msg']);
            return redirect('video/create')->withInput();
        }
    }

    public function delete($id)
    {
        $video = Video::find($id);

        if($video){
            $video->delete();
            Flash::success('<i class="fa fa-check"></i> Vídeo excluído com sucesso');
        }else{
            Flash::error('<i class="fa fa-check"></i> Erro ao excluir o vídeo');
        }
        return redirect('gercont/videos')->withInput();
    }
}