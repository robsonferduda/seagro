@extends('layouts.admin')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title">
                        <i class="nc-icon nc-tag-content"></i> Evento
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i> Editar 
                    </h4>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('gercont/eventos') }}" class="btn btn-info pull-right ml-3"><i class="nc-icon nc-tag-content"></i> Eventos</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                @include('layouts.mensagens')
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" method="POST" action="{{ route('evento.update', $evento->id) }}" enctype="multipart/form-data" id="formEvento">
                        @csrf
                        @method('PUT')
                        <div class="form-group px-3 w-100">
                            <div class="row">
                                <!-- Tipo de Evento e Data -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tipo de Evento <span class="text-danger">*</span></label>
                                        @php
                                            $listaTipos = $tipos ?? collect();
                                        @endphp
                                        <select class="form-control" name="id_tipo" id="id_tipo" required {{ $listaTipos->isEmpty() ? 'disabled' : '' }}>
                                            @if($listaTipos->isEmpty())
                                                <option value="">Nenhum tipo de evento cadastrado</option>
                                            @else
                                                <option value="">Selecione...</option>
                                                @foreach($listaTipos as $tipo)
                                                    <option value="{{ $tipo->id }}" {{ old('id_tipo', $evento->id_tipo) == $tipo->id ? 'selected' : '' }}>
                                                        {{ $tipo->nm_tipo ?? $tipo->nome ?? $tipo->descricao ?? ('Tipo ' . $tipo->id) }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if($listaTipos->isEmpty())
                                            <small class="text-warning d-block mt-1">Cadastre ao menos um tipo de evento para continuar.</small>
                                        @endif
                                        @error('id_tipo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Data do Evento <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control datepicker" name="data" required value="{{ old('data', date('d/m/Y', strtotime($evento->data))) }}" placeholder="dd/mm/aaaa">
                                        @error('data')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Evento Ativo?</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="fl_ativo" value="1" {{ old('fl_ativo', $evento->fl_ativo) ? 'checked' : '' }}>
                                                <span class="form-check-sign">Sim (O evento será exibido na página inicial do site)</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Título -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Título <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="titulo" id="titulo" minlength="3" required placeholder="Ex: Assembleia Geral Extraordinária - Plano Anual de Trabalho" value="{{ old('titulo', $evento->titulo) }}">
                                        <small class="form-text text-muted">
                                            <i class="fa fa-info-circle"></i> O apelido/slug será gerado automaticamente: <strong>{{ $evento->apelido }}</strong>
                                        </small>
                                        @error('titulo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Imagem -->
                                <div class="col-md-12">
                                    <hr>
                                    <h5 class="mb-3"><i class="fa fa-upload"></i> Imagem/Arquivo do Evento</h5>
                                    <p class="text-muted"><small><i class="fa fa-info-circle"></i> Deixe em branco se não quiser alterar o arquivo. O arquivo enviado aparece automaticamente na página do evento.</small></p>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="imagem">Imagem/PDF <small class="text-muted">(opcional)</small></label>
                                        @if($evento->imagem)
                                            <p class="text-muted mb-1"><small>Atual: {{ $evento->imagem }}</small></p>
                                        @endif
                                        <div class="input-group mb-2">
                                            <div class="custom-file">
                                                <input type="file" name="imagem" class="custom-file-input file-input" id="imagem" accept="image/*,.pdf">
                                                <label class="custom-file-label" for="imagem">Selecionar novo arquivo</label>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">Formatos: JPG, PNG, JPEG ou PDF (máx. 5MB)</small>
                                        @error('imagem')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Preview da Imagem Atual -->
                                @if($evento->imagem && !str_ends_with($evento->imagem, '.pdf'))
                                <div class="col-md-12 mt-3">
                                    <label>Imagem/Arquivo Atual:</label>
                                    <div class="text-center">
                                        <img src="{{ url('img/eventos/'.$evento->imagem) }}" alt="Imagem atual" class="img-thumbnail" style="max-width: 500px; max-height: 400px;">
                                    </div>
                                </div>
                                @endif

                                <!-- Preview da Nova Imagem -->
                                <div class="col-md-12">
                                    <div id="preview-container" class="mt-3" style="display: none;">
                                        <label>Preview da Nova Imagem:</label>
                                        <div class="text-center">
                                            <img id="preview-image" src="" alt="Preview" class="img-thumbnail" style="max-width: 500px; max-height: 400px;">
                                        </div>
                                    </div>
                                </div>

                                @include('evento._destino_fields', ['evento' => $evento])
                            </div>

                            <!-- Informações Adicionais -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <i class="fa fa-info-circle"></i> <strong>Informações:</strong>
                                        <ul class="mb-0 mt-2">
                                            <li>Deixe o campo de arquivo em branco para manter o arquivo atual</li>
                                            <li>O <strong>apelido/slug</strong> será regenerado automaticamente a partir do título e data</li>
                                            <li>Se alterar o título ou data, a URL do evento também mudará</li>
                                            <li><strong>Página própria:</strong> use o upload para cartaz/PDF e o editor para texto/links</li>
                                            <li><strong>Redirecionar:</strong> envia o visitante para outra URL ao clicar no evento</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Botões -->
                            <div class="text-center mb-2 mt-4">
                                <button type="submit" class="btn btn-success btn-lg" id="btnSalvar"><i class="fa fa-save"></i> Atualizar Evento</button>
                                <a href="{{ url('gercont/eventos') }}" class="btn btn-danger btn-lg"><i class="fa fa-times"></i> Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

@section('script')    
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/lang/summernote-pt-BR.min.js"></script>
    @include('evento._editor_descricao')
    <script>
        $(document).ready(function(){
            $('.datepicker').datetimepicker({
                format: 'DD/MM/YYYY',
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down",
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-screenshot',
                    clear: 'fa fa-trash',
                    close: 'fa fa-remove'
                }
            });

            function toggleDestinoPanels() {
                var tipo = $('input[name="tp_destino"]:checked').val() || 'conteudo';
                if (tipo === 'redirect') {
                    $('#painel-conteudo').addClass('d-none-destino');
                    $('#painel-redirect').removeClass('d-none-destino');
                } else {
                    $('#painel-redirect').addClass('d-none-destino');
                    $('#painel-conteudo').removeClass('d-none-destino');
                    setTimeout(function () {
                        window.SeagroEventoEditor.resize('descricao');
                    }, 50);
                }
                $('.destino-option').removeClass('is-selected');
                $('.destino-option[data-destino="' + tipo + '"]').addClass('is-selected');
            }

            $(document).on('change click', 'input[name="tp_destino"]', toggleDestinoPanels);
            $(document).on('click', '.destino-option', function () {
                var radio = $(this).find('input[name="tp_destino"]')[0];
                if (radio) {
                    radio.checked = true;
                    toggleDestinoPanels();
                }
            });
            toggleDestinoPanels();
            window.SeagroEventoEditor.init('descricao');

            $('.file-input').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);

                if (this.id === 'imagem' && this.files && this.files[0]) {
                    var file = this.files[0];
                    if (file.type.includes('image')) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#preview-image').attr('src', e.target.result);
                            $('#preview-container').slideDown();
                        }
                        reader.readAsDataURL(file);
                    } else {
                        $('#preview-container').slideUp();
                    }
                }
            });

            $('#formEvento').on('submit', function(e) {
                window.SeagroEventoEditor.sync('descricao');

                var valid = true;
                var messages = [];
                var tipo = $('input[name="tp_destino"]:checked').val();

                if (tipo === 'redirect') {
                    var urlDestino = $.trim($('#url_destino').val() || '');
                    if (!urlDestino) {
                        valid = false;
                        messages.push('Informe a URL de destino para redirecionamento');
                    }
                }

                var imagemFile = $('#imagem')[0].files[0];
                if (imagemFile && imagemFile.size > 5 * 1024 * 1024) {
                    valid = false;
                    messages.push('O arquivo não pode ser maior que 5MB');
                }

                if (!valid) {
                    e.preventDefault();
                    var errorMsg = '<strong>Erros encontrados:</strong><ul>';
                    messages.forEach(function(msg) {
                        errorMsg += '<li>' + msg + '</li>';
                    });
                    errorMsg += '</ul>';
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Validação',
                        html: errorMsg
                    });
                    return false;
                }

                $('#btnSalvar').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Atualizando...');
            });
        });
    </script>
@endsection
