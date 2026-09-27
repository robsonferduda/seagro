@extends('layouts.admin')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css" rel="stylesheet">
@include('partials.admin_form_style')
@endsection

@section('content')
<div class="col-md-12 noticia-form">
    <div class="nf-hero">
        <div>
            <h3><i class="fa fa-globe"></i> Nova página</h3>
            <p>Depois de salvar, você poderá anexar documentos (PDFs) à página.</p>
        </div>
        <div class="d-flex flex-wrap" style="gap:0.4rem;">
            <a href="{{ url('gercont/paginas') }}" class="btn btn-sm btn-light"><i class="fa fa-arrow-left"></i> Voltar</a>
        </div>
    </div>

    @include('layouts.mensagens')

    <form method="POST" action="{{ url('pagina-admin') }}" id="formPagina">
        @csrf
        <div class="row align-items-start">
            <div class="col-lg-8">
                <div class="nf-panel">
                    <div class="nf-panel-title">Conteúdo</div>

                    <div class="form-group">
                        <label>Título <span class="text-danger">*</span></label>
                        <input type="text" class="form-control nf-titulo" name="titulo" id="titulo" minlength="3"
                               required placeholder="Título da página" value="{{ old('titulo') }}">
                    </div>

                    <div class="form-group mb-0">
                        <label for="text">Texto</label>
                        <textarea name="text" id="text" rows="12">{{ old('text') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="nf-panel nf-panel-side">
                    <div class="nf-panel-title">Publicação</div>

                    <div class="form-group mb-2">
                        <label>Endereço <small class="text-muted">(opcional)</small></label>
                        <small class="text-muted d-block mb-1">{{ url('pagina') }}/</small>
                        <input type="text" class="form-control" name="apelido" id="apelido"
                               value="{{ old('apelido') }}" placeholder="gerado a partir do título">
                    </div>

                    <label class="nf-switch">
                        <span>Publicar<small>Visível no site</small></span>
                        <input type="checkbox" name="fl_publicacao" value="1" {{ old('fl_publicacao', 1) ? 'checked' : '' }}>
                    </label>
                </div>

                <div class="nf-actions">
                    <a href="{{ url('gercont/paginas') }}" class="btn btn-default"><i class="fa fa-times"></i> Cancelar</a>
                    <button type="submit" class="btn btn-success" id="btnSalvar"><i class="fa fa-save"></i> Criar página</button>
                </div>
            </div>
        </div>
    </form>
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
    window.SeagroNoticiaEditor.init('text', { placeholder: 'Escreva o texto da página...' });

    $('#formPagina').on('submit', function () {
        window.SeagroNoticiaEditor.sync('text');
        $('#btnSalvar').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Salvando...');
    });
});
</script>
@endsection
