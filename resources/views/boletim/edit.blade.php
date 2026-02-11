@extends('layouts.admin')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title">
                        <i class="fa fa-files-o ml-3"></i> Boletim
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i> Editar 
                    </h4>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('gercont/boletins') }}" class="btn btn-info pull-right ml-3"><i class="fa fa-files-o"></i> Boletins</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                @include('layouts.mensagens')
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" method="POST" action="{{ route('boletim.update', $boletim->id) }}" enctype="multipart/form-data" id="formBoletim">
                        @csrf
                        @method('PUT')
                        <div class="form-group px-3 w-100">
                            <div class="row">
                                <!-- Data de Publicação e Flag de Publicação -->
                                <div class="col-md-2 col-sm-6">
                                    <div class="form-group">
                                        <label>Data de Publicação <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control datepicker" name="dt_publicacao" required="true" value="{{ old('dt_publicacao', date('d/m/Y', strtotime($boletim->dt_publicacao))) }}" placeholder="dd/mm/aaaa">
                                        @error('dt_publicacao')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6">
                                    <div class="form-group">
                                        <label>Publicado?</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="fl_publicacao" value="1" {{ old('fl_publicacao', $boletim->fl_publicacao) ? 'checked' : '' }}>
                                                <span class="form-check-sign">Sim</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Título -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Título <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="titulo" id="titulo" minlength="3" required placeholder="Ex: Boletim Empresas Públicas nº 04 - Campanha Salarial 2024/2025" value="{{ old('titulo', $boletim->titulo) }}">
                                        @error('titulo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Subtítulo -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Subtítulo <small class="text-muted">(opcional)</small></label>
                                        <input type="text" class="form-control" name="subtitulo" id="subtitulo" placeholder="Subtítulo do boletim" value="{{ old('subtitulo', $boletim->subtitulo) }}">
                                        @error('subtitulo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Uploads de Arquivos -->
                                <div class="col-md-12">
                                    <hr>
                                    <h5 class="mb-3"><i class="fa fa-upload"></i> Arquivos do Boletim</h5>
                                    <p class="text-muted"><small><i class="fa fa-info-circle"></i> Deixe em branco se não quiser alterar o arquivo</small></p>
                                </div>

                                <!-- PDF -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pdf">Arquivo PDF</label>
                                        @if($boletim->arquivo)
                                            <p class="text-muted mb-1"><small>Atual: <a href="{{ url('boletim/'.$boletim->arquivo) }}" target="_blank">{{ $boletim->arquivo }}</a></small></p>
                                        @endif
                                        <div class="input-group mb-2">
                                            <div class="custom-file">
                                                <input type="file" name="pdf" class="custom-file-input file-input" id="pdf" accept=".pdf">
                                                <label class="custom-file-label" for="pdf">Selecionar novo PDF</label>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">Formato: PDF (máx. 10MB)</small>
                                        @error('pdf')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Imagem -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="imagem">Arquivo Imagem</label>
                                        @if($boletim->imagem)
                                            <p class="text-muted mb-1"><small>Atual: {{ $boletim->imagem }}</small></p>
                                        @endif
                                        <div class="input-group mb-2">
                                            <div class="custom-file">
                                                <input type="file" name="imagem" class="custom-file-input file-input" id="imagem" accept="image/*">
                                                <label class="custom-file-label" for="imagem">Selecionar nova Imagem</label>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">Formatos: JPG, PNG, JPEG (máx. 5MB)</small>
                                        @error('imagem')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Áudio -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="audio">Arquivo Áudio <small class="text-muted">(opcional)</small></label>
                                        @if($boletim->audio)
                                            <p class="text-muted mb-1"><small>Atual: {{ $boletim->audio }}</small></p>
                                        @endif
                                        <div class="input-group mb-2">
                                            <div class="custom-file">
                                                <input type="file" name="audio" class="custom-file-input file-input" id="audio" accept="audio/*">
                                                <label class="custom-file-label" for="audio">Selecionar novo Áudio</label>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">Formatos: MP3, WAV (máx. 20MB)</small>
                                        @error('audio')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Preview da Imagem Atual -->
                                @if($boletim->imagem)
                                <div class="col-md-12 mt-3">
                                    <label>Imagem Atual:</label>
                                    <div class="text-center">
                                        <img src="{{ url('boletim/'.$boletim->imagem) }}" alt="Imagem atual" class="img-thumbnail" style="max-width: 500px; max-height: 400px;">
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

                                <!-- Texto/Conteúdo - Campo Oculto (gerado automaticamente) -->
                                <input type="hidden" name="texto" id="texto" value="">
                            </div>

                            <!-- Informações Adicionais -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <i class="fa fa-info-circle"></i> <strong>Informações:</strong>
                                        <ul class="mb-0 mt-2">
                                            <li>Deixe os campos de arquivo em branco para manter os arquivos atuais</li>
                                            <li>Se alterar algum arquivo, o novo será salvo com o padrão: <code>boletim-AAAA-MM-DD.extensão</code></li>
                                            <li>O conteúdo HTML será regenerado automaticamente se você alterar a imagem</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Estatísticas -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="alert alert-secondary">
                                        <i class="fa fa-chart-bar"></i> <strong>Estatísticas:</strong>
                                        <ul class="mb-0 mt-2">
                                            <li><strong>Acessos:</strong> {{ $boletim->acessos }}</li>
                                            <li><strong>Downloads:</strong> {{ $boletim->downloads }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Botões -->
                            <div class="text-center mb-2 mt-4">
                                <button type="submit" class="btn btn-success btn-lg" id="btnSalvar"><i class="fa fa-save"></i> Atualizar Boletim</button>
                                <a href="{{ url('gercont/boletins') }}" class="btn btn-danger btn-lg"><i class="fa fa-times"></i> Cancelar</a>
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
    <script>
        $(document).ready(function(){
            // Inicializa datepicker
            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                language: 'pt-BR',
                autoclose: true,
                todayHighlight: true
            });

            // Mostra o nome do arquivo selecionado
            $('.file-input').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);

                // Preview da imagem
                if (this.id === 'imagem' && this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-image').attr('src', e.target.result);
                        $('#preview-container').slideDown();
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Validação adicional antes de enviar
            $('#formBoletim').on('submit', function(e) {
                var valid = true;
                var messages = [];

                // Validar PDF (se enviado)
                var pdfFile = $('#pdf')[0].files[0];
                if (pdfFile) {
                    if (pdfFile.size > 10 * 1024 * 1024) {
                        valid = false;
                        messages.push('O arquivo PDF não pode ser maior que 10MB');
                    }
                    if (!pdfFile.type.includes('pdf')) {
                        valid = false;
                        messages.push('O arquivo PDF deve ser do tipo PDF');
                    }
                }

                // Validar Imagem (se enviada)
                var imagemFile = $('#imagem')[0].files[0];
                if (imagemFile) {
                    if (imagemFile.size > 5 * 1024 * 1024) {
                        valid = false;
                        messages.push('A imagem não pode ser maior que 5MB');
                    }
                    if (!imagemFile.type.includes('image')) {
                        valid = false;
                        messages.push('O arquivo de imagem deve ser uma imagem válida');
                    }
                }

                // Validar Áudio (opcional - se enviado)
                var audioFile = $('#audio')[0].files[0];
                if (audioFile) {
                    if (audioFile.size > 20 * 1024 * 1024) {
                        valid = false;
                        messages.push('O arquivo de áudio não pode ser maior que 20MB');
                    }
                    if (!audioFile.type.includes('audio')) {
                        valid = false;
                        messages.push('O arquivo deve ser um áudio válido');
                    }
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
                        title: 'Validação de Arquivos',
                        html: errorMsg
                    });
                    return false;
                }

                // Desabilita botão de envio para evitar duplo clique
                $('#btnSalvar').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Atualizando...');
            });
        });
    </script>
@endsection
