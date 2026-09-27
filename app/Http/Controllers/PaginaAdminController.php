<?php

namespace App\Http\Controllers;

use App\Models\Pagina;
use App\Models\PaginaDocumento;
use App\Support\HtmlLimpeza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laracasts\Flash\Flash;

class PaginaAdminController extends Controller
{
    private const MIMES_DOCUMENTO = 'pdf,doc,docx,xls,xlsx,odt,ods,ppt,pptx,jpg,jpeg,png';
    private const MAX_DOCUMENTO_KB = 20480;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        Session::put('url', 'paginas');

        return view('pagina_admin/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'  => 'required|min:3|max:255',
            'apelido' => 'nullable|max:255',
            'text'    => 'nullable',
        ]);

        $apelido = $this->gerarApelido($request->apelido ?: $request->titulo);

        $pagina = new Pagina();
        $pagina->titulo = $request->titulo;
        $pagina->apelido = $apelido;
        $pagina->text = HtmlLimpeza::limpar($request->text);
        $pagina->fl_publicacao = $request->has('fl_publicacao') ? 1 : 0;
        $pagina->nu_visualizacoes = 0;
        $pagina->save();

        Flash::success('<i class="fa fa-check"></i> Página criada. Endereço: <strong>pagina/' . e($apelido) . '</strong>');

        return redirect('pagina-admin/' . $pagina->id . '/edit');
    }

    public function edit($id)
    {
        Session::put('url', 'paginas');

        $pagina = Pagina::findOrFail($id);
        $documentos = $pagina->documentos()->ordenados()->get();

        return view('pagina_admin/edit', compact('pagina', 'documentos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|min:3|max:255',
            'text'   => 'nullable',
        ]);

        $pagina = Pagina::findOrFail($id);
        $pagina->titulo = $request->titulo;
        $pagina->text = HtmlLimpeza::limpar($request->text);
        $pagina->fl_publicacao = $request->has('fl_publicacao') ? 1 : 0;
        $pagina->save();

        Flash::success('<i class="fa fa-check"></i> Página atualizada com sucesso!');

        return redirect('pagina-admin/' . $pagina->id . '/edit');
    }

    public function storeDocumento(Request $request, $id)
    {
        $pagina = Pagina::findOrFail($id);

        $request->validate($this->regrasDocumento(true), $this->mensagensDocumento());

        $documento = new PaginaDocumento([
            'id_pagina'     => $pagina->id,
            'titulo'        => $request->titulo,
            'subtitulo'     => $request->subtitulo,
            'dt_publicacao' => $request->dt_publicacao ?: null,
            'nu_ordem'      => (int) ($request->nu_ordem ?: 0),
            'fl_ativo'      => $request->has('fl_ativo') ? 1 : 0,
        ]);
        $documento->arquivo = $request->hasFile('arquivo')
            ? $this->salvarArquivo($request->file('arquivo'))
            : trim($request->link);
        $documento->save();

        Flash::success('<i class="fa fa-check"></i> Documento adicionado com sucesso!');

        return redirect('pagina-admin/' . $pagina->id . '/edit#documentos');
    }

    public function updateDocumento(Request $request, $id)
    {
        $documento = PaginaDocumento::findOrFail($id);

        $request->validate($this->regrasDocumento(false), $this->mensagensDocumento());

        $documento->titulo = $request->titulo;
        $documento->subtitulo = $request->subtitulo;
        $documento->dt_publicacao = $request->dt_publicacao ?: null;
        $documento->nu_ordem = (int) ($request->nu_ordem ?: 0);
        $documento->fl_ativo = $request->has('fl_ativo') ? 1 : 0;

        if ($request->hasFile('arquivo')) {
            $this->removerArquivo($documento);
            $documento->arquivo = $this->salvarArquivo($request->file('arquivo'));
        } elseif (trim((string) $request->link) !== '' && trim($request->link) !== $documento->arquivo) {
            $this->removerArquivo($documento);
            $documento->arquivo = trim($request->link);
        }

        $documento->save();

        Flash::success('<i class="fa fa-check"></i> Documento atualizado com sucesso!');

        return redirect('pagina-admin/' . $documento->id_pagina . '/edit#documentos');
    }

    public function toggleDocumento($id)
    {
        $documento = PaginaDocumento::findOrFail($id);
        $documento->fl_ativo = $documento->fl_ativo ? 0 : 1;
        $documento->save();

        return redirect('pagina-admin/' . $documento->id_pagina . '/edit#documentos');
    }

    public function destroyDocumento($id)
    {
        $documento = PaginaDocumento::findOrFail($id);
        $idPagina = $documento->id_pagina;

        $this->removerArquivo($documento);
        $documento->delete();

        Flash::success('<i class="fa fa-check"></i> Documento removido com sucesso!');

        return redirect('pagina-admin/' . $idPagina . '/edit#documentos');
    }

    private function regrasDocumento(bool $novo): array
    {
        $arquivo = 'nullable|file|mimes:' . self::MIMES_DOCUMENTO . '|max:' . self::MAX_DOCUMENTO_KB;

        return [
            'titulo'        => 'required|min:3|max:255',
            'subtitulo'     => 'nullable|max:255',
            'dt_publicacao' => 'nullable|date',
            'nu_ordem'      => 'nullable|integer',
            'arquivo'       => $novo ? $arquivo . '|required_without:link' : $arquivo,
            'link'          => 'nullable|max:500|regex:#^(https?://|/)#i',
        ];
    }

    private function mensagensDocumento(): array
    {
        return [
            'arquivo.required_without' => 'Envie um arquivo ou informe um link.',
            'arquivo.mimes'            => 'Formatos aceitos: PDF, Word, Excel, PowerPoint, ODT/ODS, JPG ou PNG.',
            'arquivo.max'              => 'O arquivo não pode ser maior que 20MB.',
            'link.regex'               => 'O link deve começar com http://, https:// ou /.',
        ];
    }

    private function salvarArquivo($arquivo): string
    {
        $destino = public_path('documentos');
        if (!is_dir($destino)) {
            mkdir($destino, 0775, true);
        }

        $base = Str::slug(pathinfo($arquivo->getClientOriginalName(), PATHINFO_FILENAME)) ?: 'documento';
        $nome = $base . '-' . time() . '.' . strtolower($arquivo->getClientOriginalExtension());
        $arquivo->move($destino, $nome);

        return 'documentos/' . $nome;
    }

    private function removerArquivo(PaginaDocumento $documento): void
    {
        if ($documento->arquivoRemovivel()) {
            @unlink($documento->caminhoLocal());
        }
    }

    private function gerarApelido(string $texto): string
    {
        $base = Str::slug($texto) ?: 'pagina';
        $apelido = $base;
        $i = 1;
        while (Pagina::withTrashed()->where('apelido', $apelido)->exists()) {
            $apelido = $base . '-' . $i++;
        }

        return $apelido;
    }
}
