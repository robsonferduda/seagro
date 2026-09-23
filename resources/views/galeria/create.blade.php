@extends('layouts.admin')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title">
                        <i class="fa fa-picture-o"></i> Galeria
                        <i class="fa fa-angle-double-right"></i> Enviar imagens
                    </h4>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('gercont/galeria') }}" class="btn btn-info pull-right ml-3"><i class="fa fa-picture-o"></i> Galeria</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                @include('layouts.mensagens')
            </div>

            <form method="POST" action="{{ url('galeria') }}" enctype="multipart/form-data" id="formGaleria">
                @csrf
                <div class="row px-3">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Título / legenda <small class="text-muted">(opcional — aplicado a todas se enviar várias)</small></label>
                            <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}" placeholder="Ex: Banner campanha salarial">
                            @error('titulo') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Imagens <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file"
                                       class="custom-file-input"
                                       name="imagens[]"
                                       id="imagens"
                                       accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                       multiple
                                       required>
                                <label class="custom-file-label" for="imagens">Selecionar uma ou mais imagens</label>
                            </div>
                            <small class="form-text text-muted">
                                JPG, PNG, GIF ou WEBP · máx. 5MB cada · salvas em <code>public/img/galeria/</code>
                            </small>
                            @error('imagens') <small class="text-danger d-block">{{ $message }}</small> @enderror
                            @error('imagens.*') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div id="preview-galeria" class="row"></div>
                    </div>
                </div>

                <div class="alert alert-info mx-3">
                    <i class="fa fa-info-circle"></i>
                    Após o upload, use o botão <strong>Copiar URL</strong> na galeria e cole no editor de notícias, eventos ou páginas
                    (ex.: <code>&lt;img src="URL" width="100%"&gt;</code>).
                </div>

                <div class="text-center mb-3 mt-3">
                    <button type="submit" class="btn btn-success btn-lg" id="btnSalvar"><i class="fa fa-upload"></i> Enviar</button>
                    <a href="{{ url('gercont/galeria') }}" class="btn btn-danger btn-lg"><i class="fa fa-times"></i> Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        $('#imagens').on('change', function () {
            var files = this.files;
            var label = files.length === 1 ? files[0].name : (files.length + ' arquivos selecionados');
            $(this).next('.custom-file-label').html(label);

            var preview = $('#preview-galeria').empty();
            Array.prototype.forEach.call(files, function (file) {
                if (!file.type.match('image.*')) return;
                var reader = new FileReader();
                reader.onload = function (e) {
                    preview.append(
                        '<div class="col-md-3 col-sm-4 mb-3">' +
                        '<img src="' + e.target.result + '" class="img-thumbnail" style="width:100%;height:140px;object-fit:cover;">' +
                        '<small class="d-block text-muted mt-1">' + file.name + '</small>' +
                        '</div>'
                    );
                };
                reader.readAsDataURL(file);
            });
        });

        $('#formGaleria').on('submit', function () {
            $('#btnSalvar').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Enviando...');
        });
    });
</script>
@endsection
