@extends('layouts.admin')
@section('style')
@endsection
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title">
                        <i class="fa fa-newspaper-o"></i> Notícias
                        <i class="fa fa-angle-double-right"></i> Nova
                    </h4>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('gercont/noticias') }}" class="btn btn-info pull-right ml-3"><i class="fa fa-newspaper-o"></i> Notícias</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                @include('layouts.mensagens')
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" method="POST" action="{{ url('noticia-admin') }}" enctype="multipart/form-data" id="formNoticia">
                        @csrf
                        <div class="form-group px-3 w-100">
                            <div class="row">

                                <!-- Data e Flags -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Data de Publicação <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control datepicker" name="dt_noticia" required
                                            value="{{ old('dt_noticia', date('d/m/Y')) }}" placeholder="dd/mm/aaaa">
                                        @error('dt_noticia')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Publicar?</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="fl_ativa" value="1" {{ old('fl_ativa', 1) ? 'checked' : '' }}>
                                                <span class="form-check-sign">Ativa</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Banner?</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="fl_banner" value="1" {{ old('fl_banner') ? 'checked' : '' }}>
                                                <span class="form-check-sign">Exibir no banner</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Título -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Título <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="titulo" id="titulo" minlength="3"
                                            required placeholder="Título da notícia" value="{{ old('titulo') }}">
                                        @error('titulo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Subtítulo -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Subtítulo <small class="text-muted">(opcional)</small></label>
                                        <input type="text" class="form-control" name="subtitulo"
                                            placeholder="Breve descrição exibida abaixo do título" value="{{ old('subtitulo') }}">
                                        @error('subtitulo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Imagem de Capa -->
                                <div class="col-md-12"><hr><h5 class="mb-3"><i class="fa fa-image"></i> Imagem de Capa</h5></div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="img_capa">Imagem <small class="text-muted">(opcional)</small></label>
                                        <div class="input-group mb-2">
                                            <div class="custom-file">
                                                <input type="file" name="img_capa" class="custom-file-input file-input"
                                                    id="img_capa" accept="image/*">
                                                <label class="custom-file-label" for="img_capa">Selecionar Imagem</label>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">Formatos: JPG, PNG, JPEG (máx. 5MB). Recomendado: 1200×630px.</small>
                                        @error('img_capa')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div id="preview-container" class="mt-2 mb-3" style="display: none;">
                                        <img id="preview-image" src="" alt="Preview" class="img-thumbnail" style="max-width:400px; max-height:280px;">
                                    </div>
                                </div>

                                <!-- Conteúdo -->
                                <div class="col-md-12 mt-2"><hr>
                                    <div class="form-group">
                                        <label for="corpo">Conteúdo <span class="text-danger">*</span></label>
                                        <textarea name="corpo" id="corpo" rows="12">{{ old('corpo') }}</textarea>
                                        @error('corpo')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <!-- Botões -->
                            <div class="text-center mb-2 mt-4">
                                <button type="submit" class="btn btn-success btn-lg" id="btnSalvar">
                                    <i class="fa fa-save"></i> Salvar Notícia
                                </button>
                                <a href="{{ url('gercont/noticias') }}" class="btn btn-danger btn-lg">
                                    <i class="fa fa-times"></i> Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="https://cdn.ckeditor.com/4.25.1-lts/full/ckeditor.js"></script>
    <script>
        $(document).ready(function(){

            // CKEditor
            CKEDITOR.replace('corpo', {
                language: 'pt',
                height: 450,
                allowedContent: true
            });

            // Datepicker
            $('.datepicker').datetimepicker({
                format: 'DD/MM/YYYY'
            });

            // Preview da imagem
            $('#img_capa').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);

                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-image').attr('src', e.target.result);
                        $('#preview-container').slideDown();
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Submit
            $('#formNoticia').on('submit', function() {
                for (var instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
                $('#btnSalvar').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Salvando...');
            });
        });
    </script>
@endsection
