@extends('layouts.admin')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
.noticia-form {
    --nf-navy: #284866;
    --nf-blue: #336693;
    --nf-muted: #6b7c8f;
    --nf-border: #e3e8ee;
    --nf-bg: #f5f8fb;
}
.noticia-form .nf-hero {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.25rem;
    padding: 1.1rem 1.25rem;
    background: linear-gradient(135deg, #284866 0%, #336693 100%);
    border-radius: 10px;
    color: #fff;
}
.noticia-form .nf-hero h3 {
    margin: 0 0 0.2rem;
    font-size: 1.25rem;
    font-weight: 700;
    color: #fff;
}
.noticia-form .nf-hero p {
    margin: 0;
    opacity: 0.85;
    font-size: 0.9rem;
}
.noticia-form .nf-hero .btn { margin: 0 !important; }
.noticia-form .nf-panel {
    background: #fff;
    border: 1px solid var(--nf-border);
    border-radius: 10px;
    padding: 1.15rem 1.25rem;
    margin-bottom: 1rem;
}
.noticia-form .nf-panel-conteudo {
    height: 100%;
}
.noticia-form .nf-panel-side {
    padding: 0.9rem 1rem;
    margin-bottom: 0.85rem;
}
.noticia-form .nf-panel-title {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: var(--nf-muted);
    font-weight: 700;
    margin-bottom: 0.75rem;
    padding-bottom: 0.4rem;
    border-bottom: 1px solid var(--nf-border);
}
.noticia-form label {
    font-weight: 600;
    color: var(--nf-navy);
    font-size: 0.85rem;
}
.noticia-form .form-control {
    border-radius: 6px;
    border-color: #d7dee8;
}
.noticia-form .form-control:focus {
    border-color: #51cbce;
    box-shadow: none;
}
.noticia-form .nf-titulo {
    font-size: 1.15rem;
    font-weight: 600;
    padding: 0.7rem 0.9rem;
    height: auto;
}
.noticia-form .nf-switch {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
    padding: 0.5rem 0.65rem;
    background: var(--nf-bg);
    border: 1px solid var(--nf-border);
    border-radius: 8px;
    margin-bottom: 0.45rem;
}
.noticia-form .nf-switch:last-of-type { margin-bottom: 0; }
.noticia-form .nf-switch span {
    font-size: 0.82rem;
    color: var(--nf-navy);
    font-weight: 600;
}
.noticia-form .nf-switch small {
    display: block;
    font-weight: 400;
    color: var(--nf-muted);
    font-size: 0.7rem;
}
.noticia-form .nf-capa-box {
    border: 2px dashed #c5d3e0;
    border-radius: 8px;
    padding: 0.65rem;
    text-align: center;
    background: var(--nf-bg);
}
.noticia-form .nf-capa-preview {
    width: 100%;
    height: 88px;
    object-fit: cover;
    border-radius: 6px;
    margin-bottom: 0.5rem;
}
.noticia-form .nf-capa-empty {
    padding: 0.55rem 0.25rem;
    color: var(--nf-muted);
    font-size: 0.78rem;
}
.noticia-form .nf-capa-empty i {
    font-size: 1.35rem;
    display: block;
    margin-bottom: 0.25rem;
}
.noticia-form .nf-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    justify-content: flex-end;
    margin-top: 0.25rem;
    padding: 0.85rem 0 0;
    border-top: 1px solid var(--nf-border);
}
.noticia-form .nf-actions .btn { margin: 0 !important; }
.noticia-form .custom-file-label { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
</style>
@endsection

@section('content')
<div class="col-md-12 noticia-form">
    <div class="nf-hero">
        <div>
            <h3><i class="fa fa-pencil"></i> Editar notícia</h3>
            <p>{{ \Illuminate\Support\Str::limit($noticia->titulo, 80) }}</p>
        </div>
        <div class="d-flex flex-wrap" style="gap:0.4rem;">
            <a href="{{ url('gercont/noticias') }}" class="btn btn-sm btn-light"><i class="fa fa-arrow-left"></i> Voltar</a>
            <a href="{{ url('noticia/' . $noticia->url) }}" class="btn btn-sm btn-secondary" target="_blank"><i class="fa fa-external-link"></i> Ver no site</a>
            <a href="{{ url('gercont/galeria') }}" class="btn btn-sm btn-info" target="_blank"><i class="fa fa-picture-o"></i> Galeria</a>
        </div>
    </div>

    @include('layouts.mensagens')

    <form method="POST" action="{{ url('noticia-admin/' . $noticia->id) }}" enctype="multipart/form-data" id="formNoticia">
        @csrf
        <div class="row align-items-start">
            <div class="col-lg-6">
                <div class="nf-panel nf-panel-conteudo">
                    <div class="nf-panel-title">Conteúdo</div>

                    <div class="form-group">
                        <label>Título <span class="text-danger">*</span></label>
                        <input type="text" class="form-control nf-titulo" name="titulo" id="titulo" minlength="3"
                               required placeholder="Título da notícia"
                               value="{{ old('titulo', $noticia->titulo) }}">
                        @error('titulo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label>Subtítulo <small class="text-muted">(opcional)</small></label>
                        <input type="text" class="form-control" name="subtitulo"
                               placeholder="Linha de apoio exibida abaixo do título"
                               value="{{ old('subtitulo', $noticia->subtitulo) }}">
                        @error('subtitulo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mb-0">
                        <label for="corpo">Corpo do texto <span class="text-danger">*</span></label>
                        <textarea name="corpo" id="corpo" rows="12">{{ old('corpo', $noticia->corpo) }}</textarea>
                        <small class="form-text text-muted">
                            Use o botão <strong><i class="fa fa-picture-o"></i> Galeria</strong> na barra do editor para inserir imagens já enviadas.
                        </small>
                        @error('corpo') <small class="text-danger d-block">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="nf-panel nf-panel-side">
                            <div class="nf-panel-title">Publicação</div>

                            <div class="form-group mb-2">
                                <label>Data <span class="text-danger">*</span></label>
                                <input type="text" class="form-control datepicker" name="dt_noticia" required
                                       value="{{ old('dt_noticia', \Carbon\Carbon::parse($noticia->dt_noticia)->format('d/m/Y')) }}"
                                       placeholder="dd/mm/aaaa">
                                @error('dt_noticia') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <label class="nf-switch">
                                <span>Publicar<small>Visível no site</small></span>
                                <input type="checkbox" name="fl_ativa" value="1" {{ old('fl_ativa', $noticia->fl_ativa) ? 'checked' : '' }}>
                            </label>

                            <label class="nf-switch">
                                <span>Banner<small>Destaque na home</small></span>
                                <input type="checkbox" name="fl_banner" value="1" {{ old('fl_banner', $noticia->fl_banner) ? 'checked' : '' }}>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="nf-panel nf-panel-side">
                            <div class="nf-panel-title">Imagem de capa</div>
                            <div class="nf-capa-box">
                                @if($noticia->img_capa)
                                    <div id="preview-container">
                                        <img id="preview-image" src="{{ asset('img/noticias/' . $noticia->img_capa) }}" alt="Capa atual" class="nf-capa-preview">
                                    </div>
                                    <div id="capa-empty" class="nf-capa-empty" style="display:none;">
                                        <i class="fa fa-cloud-upload"></i>
                                        JPG/PNG · 5MB
                                    </div>
                                @else
                                    <div id="preview-container" style="display:none;">
                                        <img id="preview-image" src="" alt="Preview" class="nf-capa-preview">
                                    </div>
                                    <div id="capa-empty" class="nf-capa-empty">
                                        <i class="fa fa-cloud-upload"></i>
                                        JPG/PNG · 5MB<br>
                                        <small>1200×630px</small>
                                    </div>
                                @endif
                                <div class="custom-file text-left">
                                    <input type="file" name="img_capa" class="custom-file-input" id="img_capa" accept="image/*">
                                    <label class="custom-file-label" for="img_capa">{{ $noticia->img_capa ? 'Substituir capa' : 'Selecionar capa' }}</label>
                                </div>
                                @error('img_capa') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="nf-actions">
                            <a href="{{ url('gercont/noticias') }}" class="btn btn-default"><i class="fa fa-times"></i> Cancelar</a>
                            <button type="submit" class="btn btn-success" id="btnSalvar">
                                <i class="fa fa-save"></i> Salvar alterações
                            </button>
                        </div>
                    </div>
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
<script>
$(document).ready(function () {
    $('.datepicker').datetimepicker({
        format: 'DD/MM/YYYY',
        icons: {
            time: 'fa fa-clock-o', date: 'fa fa-calendar',
            up: 'fa fa-chevron-up', down: 'fa fa-chevron-down',
            previous: 'fa fa-chevron-left', next: 'fa fa-chevron-right',
            today: 'fa fa-screenshot', clear: 'fa fa-trash', close: 'fa fa-remove'
        }
    });

    var GaleriaButton = function (context) {
        var ui = $.summernote.ui;
        return ui.button({
            contents: '<i class="fa fa-picture-o"></i> Galeria',
            tooltip: 'Inserir imagem da galeria',
            click: function () {
                window.SeagroGaleriaPicker.open('corpo');
            }
        }).render();
    };

    $('#corpo').summernote({
        lang: 'pt-BR',
        height: 420,
        placeholder: 'Escreva o conteúdo da notícia...',
        dialogsInBody: true,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'hr', 'galeria']],
            ['view', ['fullscreen', 'codeview', 'undo', 'redo']]
        ],
        buttons: { galeria: GaleriaButton },
        styleTags: ['p', 'h2', 'h3', 'h4', 'blockquote']
    });

    $('#img_capa').on('change', function () {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName || 'Selecionar capa');
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview-image').attr('src', e.target.result);
                $('#preview-container').show();
                $('#capa-empty').hide();
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    $('#formNoticia').on('submit', function () {
        if ($('#corpo').next('.note-editor').length) {
            $('#corpo').val($('#corpo').summernote('code'));
        }
        $('#btnSalvar').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Salvando...');
    });
});
</script>
@endsection
