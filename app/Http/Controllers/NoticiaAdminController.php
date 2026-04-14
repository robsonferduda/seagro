<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laracasts\Flash\Flash;

class NoticiaAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('noticia/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'     => 'required|min:3|max:255',
            'dt_noticia' => 'required',
            'corpo'      => 'required',
            'img_capa'   => 'nullable|image|max:5120',
        ]);

        $url = $this->gerarUrl($request->titulo);

        $dados = [
            'titulo'     => $request->titulo,
            'subtitulo'  => $request->subtitulo,
            'dt_noticia' => implode('-', array_reverse(explode('/', $request->dt_noticia))),
            'corpo'      => $request->corpo,
            'fl_ativa'   => $request->has('fl_ativa') ? 1 : 0,
            'fl_banner'  => $request->has('fl_banner') ? 1 : 0,
            'url'        => $url,
        ];

        $noticia = Noticia::create($dados);

        if ($request->hasFile('img_capa')) {
            $ext = $request->file('img_capa')->getClientOriginalExtension();
            $request->file('img_capa')->move(public_path('img/noticias'), $noticia->id . '.' . $ext);
            $noticia->img_capa = $noticia->id . '.' . $ext;
            $noticia->save();
        }

        Flash::success('<i class="fa fa-check"></i> Notícia cadastrada com sucesso!');

        return redirect('gercont/noticias');
    }

    public function edit($id)
    {
        $noticia = Noticia::findOrFail($id);
        return view('noticia/edit', compact('noticia'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo'     => 'required|min:3|max:255',
            'dt_noticia' => 'required',
            'corpo'      => 'required',
            'img_capa'   => 'nullable|image|max:5120',
        ]);

        $noticia = Noticia::findOrFail($id);

        $noticia->titulo     = $request->titulo;
        $noticia->subtitulo  = $request->subtitulo;
        $noticia->dt_noticia = implode('-', array_reverse(explode('/', $request->dt_noticia)));
        $noticia->corpo      = $request->corpo;
        $noticia->fl_ativa   = $request->has('fl_ativa') ? 1 : 0;
        $noticia->fl_banner  = $request->has('fl_banner') ? 1 : 0;

        if ($request->hasFile('img_capa')) {
            // Remove imagem antiga se existir
            if ($noticia->img_capa) {
                $oldPath = public_path('img/noticias/' . $noticia->img_capa);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $ext = $request->file('img_capa')->getClientOriginalExtension();
            $nomeArquivo = $noticia->id . '.' . $ext;
            $request->file('img_capa')->move(public_path('img/noticias'), $nomeArquivo);
            $noticia->img_capa = $nomeArquivo;
        }

        $noticia->save();

        Flash::success('<i class="fa fa-check"></i> Notícia atualizada com sucesso!');

        return redirect('gercont/noticias');
    }

    public function destroy($id)
    {
        $noticia = Noticia::findOrFail($id);
        $noticia->delete();

        Flash::success('<i class="fa fa-check"></i> Notícia removida com sucesso!');

        return redirect('gercont/noticias');
    }

    public function toggleAtiva($id)
    {
        $noticia = Noticia::findOrFail($id);
        $noticia->fl_ativa = $noticia->fl_ativa ? 0 : 1;
        $noticia->save();

        return redirect('gercont/noticias');
    }

    private function gerarUrl(string $titulo): string
    {
        $base = Str::slug($titulo);
        $url  = $base;
        $i    = 1;
        while (Noticia::where('url', $url)->exists()) {
            $url = $base . '-' . $i++;
        }
        return $url;
    }
}
