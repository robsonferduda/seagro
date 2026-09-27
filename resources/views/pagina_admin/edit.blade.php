@extends('layouts.admin')

@php
    $htmlComplexo = (bool) preg_match('/class="[^"]*\b(row|col-[a-z0-9-]+|card[a-z-]*|forum-[a-z-]+|ibox[a-z-]*|container)\b/i', (string) $pagina->text);
    $docAberto = old('form_documento');
@endphp

@section('style')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css" rel="stylesheet">
@include('partials.admin_form_style')
<style>
.pg-docs { list-style: none; margin: 0; padding: 0; }
.pg-doc {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    padding: 0.7rem 0.4rem;
    border-bottom: 1px solid var(--nf-border);
}
.pg-doc:last-child { border-bottom: 0; }
.pg-doc.inativo { opacity: 0.55; }
.pg-doc-icon {
    flex: 0 0 38px;
    height: 38px;
    border-radius: 8px;
    background: #eef3f8;
    color: #336693;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}
.pg-doc-icon.pdf { background: #fdecec; color: #c0392b; }
.pg-doc-body { flex: 1 1 auto; min-width: 0; }
.pg-doc-titulo {
    display: block;
    font-weight: 600;
    color: var(--nf-navy);
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.pg-doc-meta { font-size: 0.78rem; color: var(--nf-muted); }
.pg-doc-meta span + span::before { content: "·"; margin: 0 0.4rem; }
.pg-doc-acoes { display: flex; gap: 0.3rem; flex: 0 0 auto; }
.pg-doc-acoes .btn { margin: 0 !important; padding: 0.3rem 0.55rem; }
.pg-docs-vazio { text-align: center; color: var(--nf-muted); padding: 1.5rem 0.5rem; }
.pg-docs-vazio i { font-size: 2rem; display: block; margin-bottom: 0.4rem; opacity: 0.5; }
.pg-badge { font-size: 0.68rem; padding: 0.15rem 0.45rem; border-radius: 10px; font-weight: 700; text-transform: uppercase; }
.pg-badge.on { background: #e3f6ec; color: #1e8449; }
.pg-badge.off { background: #f1f1f1; color: #888; }
#modalDocumento .modal-content { border-radius: 10px; }
#modalDocumento label { font-weight: 600; color: #284866; font-size: 0.85rem; }
@media (max-width: 575px) {
    .pg-doc { flex-wrap: wrap; }
    .pg-doc-acoes { width: 100%; justify-content: flex-end; }
}
</style>
@endsection

@section('content')
<div class="col-md-12 noticia-form">
    <div class="nf-hero">
        <div>
            <h3><i class="fa fa-globe"></i> Editar página</h3>
            <p>{{ $pagina->titulo }}</p>
        </div>
        <div class="d-flex flex-wrap" style="gap:0.4rem;">
            <a href="{{ url('gercont/paginas') }}" class="btn btn-sm btn-light"><i class="fa fa-arrow-left"></i> Voltar</a>
            <a href="{{ url('pagina/' . $pagina->apelido) }}" target="_blank" class="btn btn-sm btn-info"><i class="fa fa-external-link"></i> Ver no site</a>
        </div>
    </div>

    @include('layouts.mensagens')

    <form method="POST" action="{{ url('pagina-admin/' . $pagina->id) }}" id="formPagina">
        @csrf
        <div class="row align-items-start">
            <div class="col-lg-8">
                <div class="nf-panel">
                    <div class="nf-panel-title">Conteúdo</div>

                    <div class="form-group">
                        <label>Título <span class="text-danger">*</span></label>
                        <input type="text" class="form-control nf-titulo" name="titulo" id="titulo" minlength="3"
                               required value="{{ $docAberto ? $pagina->titulo : old('titulo', $pagina->titulo) }}">
                    </div>

                    @if($htmlComplexo)
                        <div class="alert alert-warning py-2 px-3" style="font-size:0.85rem;">
                            <i class="fa fa-code"></i> Esta página usa um layout em HTML. O editor abriu no <strong>modo código</strong>
                            para não desmontar a estrutura. Clique no botão <code>&lt;/&gt;</code> da barra para alternar para o modo visual.
                        </div>
                    @endif

                    <div class="form-group mb-0">
                        <label for="text">Texto</label>
                        <textarea name="text" id="text" rows="12">{{ old('text', $pagina->text) }}</textarea>
                        <small class="text-muted">Os documentos cadastrados abaixo aparecem automaticamente depois deste texto.</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="nf-panel nf-panel-side">
                    <div class="nf-panel-title">Publicação</div>

                    <div class="nf-info">Endereço:
                        <a href="{{ url('pagina/' . $pagina->apelido) }}" target="_blank"><strong>pagina/{{ $pagina->apelido }}</strong></a>
                    </div>
                    <div class="nf-info">Visualizações: <strong>{{ number_format((int) $pagina->nu_visualizacoes, 0, ',', '.') }}</strong></div>
                    @if($pagina->updated_at)
                        <div class="nf-info mb-2">Atualizada em: <strong>{{ $pagina->updated_at->format('d/m/Y H:i') }}</strong></div>
                    @endif

                    <label class="nf-switch">
                        <span>Publicada<small>Visível no site</small></span>
                        <input type="checkbox" name="fl_publicacao" value="1" {{ old('fl_publicacao', $pagina->fl_publicacao) ? 'checked' : '' }}>
                    </label>
                </div>

                <div class="nf-panel nf-panel-side">
                    <div class="nf-panel-title">Documentos</div>
                    <div class="nf-info mb-2">
                        <strong>{{ $documentos->where('fl_ativo', 1)->count() }}</strong> publicado(s) de <strong>{{ $documentos->count() }}</strong>
                    </div>
                    <a href="#documentos" class="btn btn-sm btn-outline-primary btn-block m-0"><i class="fa fa-paperclip"></i> Gerenciar documentos</a>
                </div>

                <div class="nf-actions">
                    <a href="{{ url('gercont/paginas') }}" class="btn btn-default"><i class="fa fa-times"></i> Cancelar</a>
                    <button type="submit" class="btn btn-success" id="btnSalvar"><i class="fa fa-save"></i> Salvar página</button>
                </div>
            </div>
        </div>
    </form>

    <div class="nf-panel" id="documentos">
        <div class="nf-panel-title">
            <span><i class="fa fa-paperclip"></i> Documentos da página ({{ $documentos->count() }})</span>
            <button type="button" class="btn btn-sm btn-primary m-0" id="btnNovoDocumento"><i class="fa fa-plus"></i> Adicionar documento</button>
        </div>

        @if($documentos->count())
            <ul class="pg-docs">
                @foreach($documentos as $documento)
                    <li class="pg-doc {{ $documento->fl_ativo ? '' : 'inativo' }}">
                        <div class="pg-doc-icon {{ $documento->extensao() === 'pdf' ? 'pdf' : '' }}">
                            <i class="fa {{ $documento->extensao() === 'pdf' ? 'fa-file-pdf-o' : ($documento->isExterno() ? 'fa-link' : 'fa-file-o') }}"></i>
                        </div>
                        <div class="pg-doc-body">
                            <a href="{{ $documento->urlPublica() }}" target="_blank" class="pg-doc-titulo" title="{{ $documento->titulo }}">{{ $documento->titulo }}</a>
                            <div class="pg-doc-meta">
                                <span>{{ $documento->dt_publicacao ? $documento->dt_publicacao->format('d/m/Y') : 'Sem data' }}</span>
                                @if($documento->subtitulo)<span>{{ $documento->subtitulo }}</span>@endif
                                <span>{{ strtoupper($documento->extensao() ?: 'link') }}</span>
                                <span class="pg-badge {{ $documento->fl_ativo ? 'on' : 'off' }}">{{ $documento->fl_ativo ? 'Publicado' : 'Oculto' }}</span>
                            </div>
                        </div>
                        <div class="pg-doc-acoes">
                            <button type="button" class="btn btn-sm btn-outline-primary btn-editar-doc" title="Editar"
                                    data-id="{{ $documento->id }}"
                                    data-titulo="{{ $documento->titulo }}"
                                    data-subtitulo="{{ $documento->subtitulo }}"
                                    data-data="{{ $documento->dt_publicacao ? $documento->dt_publicacao->format('Y-m-d') : '' }}"
                                    data-ordem="{{ $documento->nu_ordem }}"
                                    data-ativo="{{ $documento->fl_ativo ? 1 : 0 }}"
                                    data-arquivo="{{ $documento->arquivo }}"
                                    data-url="{{ $documento->urlPublica() }}">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <a href="{{ url('pagina-documento/' . $documento->id . '/toggle') }}" class="btn btn-sm btn-outline-secondary"
                               title="{{ $documento->fl_ativo ? 'Ocultar do site' : 'Publicar no site' }}">
                                <i class="fa {{ $documento->fl_ativo ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                            </a>
                            <form method="POST" action="{{ url('pagina-documento/' . $documento->id . '/destroy') }}" class="d-inline form-excluir-doc">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="pg-docs-vazio">
                <i class="fa fa-folder-open-o"></i>
                Nenhum documento cadastrado. Use <strong>Adicionar documento</strong> para listar PDFs (acordos, convenções, formulários) nesta página.
            </div>
        @endif
    </div>
</div>

<div class="modal fade" id="modalDocumento" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" id="formDocumento"
                  data-url-novo="{{ url('pagina-admin/' . $pagina->id . '/documentos') }}"
                  data-url-editar="{{ url('pagina-documento') }}">
                @csrf
                <input type="hidden" name="form_documento" id="docFormId" value="novo">
                <div class="modal-header">
                    <h5 class="modal-title" id="docModalTitulo">Adicionar documento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Título <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="titulo" id="docTitulo" required minlength="3" maxlength="255"
                               placeholder="Ex.: Convenção Coletiva de Trabalho 2026/2027">
                    </div>
                    <div class="form-group">
                        <label>Subtítulo <small class="text-muted">(opcional)</small></label>
                        <input type="text" class="form-control" name="subtitulo" id="docSubtitulo" maxlength="255"
                               placeholder="Ex.: Assinado em 27/05/2026">
                    </div>
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <label>Data de publicação</label>
                            <input type="date" class="form-control" name="dt_publicacao" id="docData">
                        </div>
                        <div class="col-sm-3 form-group">
                            <label>Ordem</label>
                            <input type="number" class="form-control" name="nu_ordem" id="docOrdem" value="0">
                        </div>
                        <div class="col-sm-3 form-group d-flex align-items-end">
                            <label class="nf-switch w-100 mb-0" style="background:#f5f8fb;border:1px solid #e3e8ee;border-radius:8px;padding:.45rem .6rem;display:flex;justify-content:space-between;align-items:center;">
                                <span>Publicado</span>
                                <input type="checkbox" name="fl_ativo" id="docAtivo" value="1" checked>
                            </label>
                        </div>
                    </div>

                    <div id="docArquivoAtual" class="alert alert-light border py-2 px-3 d-none" style="font-size:0.85rem;">
                        Arquivo atual: <a href="#" target="_blank" id="docArquivoAtualLink"></a>
                        <div class="text-muted">Envie um novo arquivo ou informe outro link apenas se quiser substituí-lo.</div>
                    </div>

                    <div class="form-group">
                        <label>Arquivo</label>
                        <input type="file" class="form-control-file" name="arquivo" id="docArquivo"
                               accept=".pdf,.doc,.docx,.xls,.xlsx,.odt,.ods,.ppt,.pptx,.jpg,.jpeg,.png">
                        <small class="text-muted">PDF, Word, Excel, PowerPoint, ODT/ODS, JPG ou PNG, até 20MB.</small>
                    </div>
                    <div class="form-group mb-0">
                        <label>ou link <small class="text-muted">(opcional, em vez de enviar arquivo)</small></label>
                        <input type="text" class="form-control" name="link" id="docLink" maxlength="500"
                               placeholder="https://... ou /caminho/arquivo.pdf">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" id="btnSalvarDoc"><i class="fa fa-save"></i> Salvar documento</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('partials.galeria_picker')
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/lang/summernote-pt-BR.min.js"></script>
@include('partials.galeria_picker_script')
@include('partials.summernote_noticia_init')
<script>
$(document).ready(function () {
    window.SeagroNoticiaEditor.init('text', {
        placeholder: 'Escreva o texto da página...',
        codeview: {{ $htmlComplexo ? 'true' : 'false' }}
    });

    $('#formPagina').on('submit', function () {
        window.SeagroNoticiaEditor.sync('text');
        $('#btnSalvar').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Salvando...');
    });

    var $form = $('#formDocumento');

    function abrirDocumento(dados) {
        dados = dados || {};
        var editando = !!dados.id;
        $form.attr('action', editando ? $form.data('url-editar') + '/' + dados.id : $form.data('url-novo'));
        $('#docFormId').val(editando ? 'editar:' + dados.id : 'novo');
        $('#docModalTitulo').text(editando ? 'Editar documento' : 'Adicionar documento');
        $('#docTitulo').val(dados.titulo || '');
        $('#docSubtitulo').val(dados.subtitulo || '');
        $('#docData').val(dados.data || '');
        $('#docOrdem').val(dados.ordem !== undefined && dados.ordem !== '' ? dados.ordem : 0);
        $('#docAtivo').prop('checked', dados.ativo === undefined ? true : String(dados.ativo) === '1');
        $('#docArquivo').val('');
        $('#docLink').val(dados.link || '');
        if (editando && dados.arquivo) {
            $('#docArquivoAtualLink').attr('href', dados.url || '#').text(dados.arquivo);
            $('#docArquivoAtual').removeClass('d-none');
        } else {
            $('#docArquivoAtual').addClass('d-none');
        }
        $('#btnSalvarDoc').prop('disabled', false).html('<i class="fa fa-save"></i> Salvar documento');
        $('#modalDocumento').modal('show');
    }

    $('#btnNovoDocumento').on('click', function () {
        abrirDocumento({ data: new Date().toISOString().slice(0, 10) });
    });

    $('.btn-editar-doc').on('click', function () {
        var $b = $(this);
        abrirDocumento({
            id: $b.data('id'),
            titulo: $b.data('titulo'),
            subtitulo: $b.data('subtitulo'),
            data: $b.data('data'),
            ordem: $b.data('ordem'),
            ativo: $b.data('ativo'),
            arquivo: $b.data('arquivo'),
            url: $b.data('url')
        });
    });

    $form.on('submit', function (e) {
        var novo = $('#docFormId').val() === 'novo';
        if (novo && !$('#docArquivo').val() && !$.trim($('#docLink').val())) {
            e.preventDefault();
            Swal.fire({ icon: 'warning', title: 'Arquivo obrigatório', text: 'Envie um arquivo ou informe um link.' });
            return;
        }
        $('#btnSalvarDoc').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Enviando...');
    });

    $('.form-excluir-doc').on('submit', function (e) {
        e.preventDefault();
        var form = this;
        Swal.fire({
            icon: 'warning',
            title: 'Excluir documento?',
            text: 'O documento sairá da página. Arquivos enviados pelo painel também serão apagados.',
            showCancelButton: true,
            confirmButtonText: 'Sim, excluir',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#d33'
        }).then(function (result) {
            if (result.isConfirmed || result.value) {
                form.submit();
            }
        });
    });

    @if($docAberto)
        @php
            $docId = \Illuminate\Support\Str::startsWith($docAberto, 'editar:') ? (int) substr($docAberto, 7) : null;
            $docOriginal = $docId ? $documentos->firstWhere('id', $docId) : null;
        @endphp
        abrirDocumento({!! json_encode([
            'id'        => $docId,
            'titulo'    => old('titulo'),
            'subtitulo' => old('subtitulo'),
            'data'      => old('dt_publicacao'),
            'ordem'     => old('nu_ordem'),
            'ativo'     => old('fl_ativo') ? 1 : 0,
            'link'      => old('link'),
            'arquivo'   => $docOriginal ? $docOriginal->arquivo : null,
            'url'       => $docOriginal ? $docOriginal->urlPublica() : null,
        ]) !!});
    @endif
});
</script>
@endsection
