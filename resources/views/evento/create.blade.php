@extends('layouts.admin')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title">
                        <i class="nc-icon nc-tag-content"></i> Evento
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i> Novo 
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
                    <form class="form-horizontal" method="POST" action="{{ url('evento/novo') }}" enctype="multipart/form-data" id="formEvento">
                        @csrf
                        <div class="form-group px-3 w-100">
                            <div class="row">
                                <!-- Tipo de Evento e Data -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tipo de Evento <span class="text-danger">*</span></label>
                                        <select class="form-control" name="id_tipo" id="id_tipo" required>
                                            <option value="">Selecione...</option>
                                            @foreach($tipos as $tipo)
                                                <option value="{{ $tipo->id }}" {{ old('id_tipo') == $tipo->id ? 'selected' : '' }}>
                                                    {{ $tipo->nm_tipo }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('id_tipo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Data do Evento <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control datepicker" name="data" required value="{{ old('data', date('d/m/Y')) }}" placeholder="dd/mm/aaaa">
                                        @error('data')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Evento Ativo?</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="fl_ativo" value="1" {{ old('fl_ativo', 1) ? 'checked' : '' }}>
                                                <span class="form-check-sign">Sim</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Título -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Título <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="titulo" id="titulo" minlength="3" required placeholder="Ex: Assembleia Geral Extraordinária - Plano Anual de Trabalho" value="{{ old('titulo') }}">
                                        <small class="form-text text-muted">
                                            <i class="fa fa-info-circle"></i> O apelido/slug será gerado automaticamente a partir do título para criar uma URL amigável
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
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="imagem">Imagem/PDF <small class="text-muted">(opcional)</small></label>
                                        <div class="input-group mb-2">
                                            <div class="custom-file">
                                                <input type="file" name="imagem" class="custom-file-input file-input" id="imagem" accept="image/*,.pdf">
                                                <label class="custom-file-label" for="imagem">Selecionar Arquivo</label>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">Formatos: JPG, PNG, JPEG ou PDF (máx. 5MB)</small>
                                        @error('imagem')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Preview da Imagem -->
                                <div class="col-md-12">
                                    <div id="preview-container" class="mt-3" style="display: none;">
                                        <label>Preview da Imagem:</label>
                                        <div class="text-center">
                                            <img id="preview-image" src="" alt="Preview" class="img-thumbnail" style="max-width: 500px; max-height: 400px;">
                                        </div>
                                    </div>
                                </div>

                                <!-- Descrição/Conteúdo -->
                                <div class="col-md-12 mt-3">
                                    <hr>
                                    <div class="form-group">
                                        <label for="descricao">Descrição do Evento <small class="text-muted">(opcional - aceita HTML)</small></label>
                                        <textarea class="form-control" name="descricao" id="descricao" rows="8" placeholder="Adicione informações sobre o evento...">{{ old('descricao') }}</textarea>
                                        <small class="form-text text-muted">
                                            <i class="fa fa-info-circle"></i> Você pode adicionar HTML. Por exemplo: 
                                            <code>&lt;img src="URL_DA_IMAGEM" width="100%" alt=""&gt;</code>
                                        </small>
                                        @error('descricao')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Informações Adicionais -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <i class="fa fa-info-circle"></i> <strong>Dicas:</strong>
                                        <ul class="mb-0 mt-2">
                                            <li>O <strong>apelido/slug</strong> será gerado automaticamente a partir do título e data</li>
                                            <li>Formato do slug: <code>titulo-do-evento-AAAA-MM-DD</code></li>
                                            <li>Se enviar uma imagem, ela será salva em <code>public/eventos/</code></li>
                                            <li>Você pode inserir HTML na descrição para formatação avançada</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Botões -->
                            <div class="text-center mb-2 mt-4">
                                <button type="submit" class="btn btn-success btn-lg" id="btnSalvar"><i class="fa fa-save"></i> Salvar Evento</button>
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

            // Slug será gerado automaticamente no backend

            // Mostra o nome do arquivo selecionado
            $('.file-input').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);

                // Preview da imagem (se não for PDF)
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

            // Validação adicional antes de enviar
            $('#formEvento').on('submit', function(e) {
                var valid = true;
                var messages = [];

                // Validar Imagem (se enviada)
                var imagemFile = $('#imagem')[0].files[0];
                if (imagemFile) {
                    if (imagemFile.size > 5 * 1024 * 1024) {
                        valid = false;
                        messages.push('O arquivo não pode ser maior que 5MB');
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
                $('#btnSalvar').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Salvando...');
            });
        });
    </script>
@endsection
