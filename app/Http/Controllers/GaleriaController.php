<?php

namespace App\Http\Controllers;

use App\Models\Galeria;
use App\Http\Requests\GaleriaRequest;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class GaleriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        Session::put('url', 'galeria');

        $busca = trim((string) $request->get('q', ''));

        $imagens = Galeria::when($busca !== '', function ($query) use ($busca) {
                $query->where(function ($q) use ($busca) {
                    $q->where('titulo', 'like', '%' . $busca . '%')
                      ->orWhere('arquivo', 'like', '%' . $busca . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('gercont/galeria', compact('imagens', 'busca'));
    }

    public function create()
    {
        return view('galeria/create');
    }

    public function store(GaleriaRequest $request)
    {
        $destino = public_path('img/galeria');
        if (!is_dir($destino)) {
            mkdir($destino, 0775, true);
        }

        $total = 0;
        foreach ($request->file('imagens') as $imagem) {
            $base = Str::slug(pathinfo($imagem->getClientOriginalName(), PATHINFO_FILENAME));
            if ($base === '') {
                $base = 'imagem';
            }
            $nomeArquivo = $base . '-' . time() . '-' . Str::random(4) . '.' . $imagem->getClientOriginalExtension();
            $imagem->move($destino, $nomeArquivo);

            $caminho = $destino . DIRECTORY_SEPARATOR . $nomeArquivo;

            Galeria::create([
                'titulo' => $request->titulo ?: pathinfo($imagem->getClientOriginalName(), PATHINFO_FILENAME),
                'arquivo' => $nomeArquivo,
                'mime' => mime_content_type($caminho) ?: $imagem->getClientMimeType(),
                'tamanho' => file_exists($caminho) ? filesize($caminho) : null,
            ]);

            $total++;
            // evita colisão de nomes no mesmo segundo
            usleep(20000);
        }

        Flash::success('<i class="fa fa-check"></i> ' . $total . ' imagem(ns) enviada(s) com sucesso');

        return redirect('gercont/galeria');
    }

    public function destroy($id)
    {
        $imagem = Galeria::findOrFail($id);

        if ($imagem->arquivo && file_exists($imagem->caminhoLocal())) {
            @unlink($imagem->caminhoLocal());
        }

        $imagem->delete();

        Flash::success('<i class="fa fa-check"></i> Imagem removida com sucesso');

        return redirect('gercont/galeria');
    }
}
