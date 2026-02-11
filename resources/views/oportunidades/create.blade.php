@extends('layouts.admin')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title">
                        <i class="nc-icon nc-briefcase-24"></i> Oportunidade
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i> Nova 
                    </h4>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('gercont/oportunidades') }}" class="btn btn-info pull-right ml-3"><i class="nc-icon nc-briefcase-24"></i> Oportunidades</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                @include('layouts.mensagens')
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal" method="POST" action="{{ route('oportunidade.store') }}" enctype="multipart/form-data" id="formOportunidade">
                        @csrf
                        <div class="form-group px-3 w-100">
                            <div class="row">
                                <!-- Tipo e Empresa -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tipo <span class="text-danger">*</span></label>
                                        <select class="form-control" name="tipo" id="tipo" required>
                                            <option value="">Selecione...</option>
                                            <option value="Emprego" {{ old('tipo') == 'Emprego' ? 'selected' : '' }}>Emprego</option>
                                            <option value="Estágio" {{ old('tipo') == 'Estágio' ? 'selected' : '' }}>Estágio</option>
                                            <option value="Freelance" {{ old('tipo') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                        </select>
                                        @error('tipo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Empresa <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="empresa" required placeholder="Nome da empresa" value="{{ old('empresa') }}">
                                        @error('empresa')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Localização <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="localizacao" required placeholder="Ex: Florianópolis - SC" value="{{ old('localizacao') }}">
                                        @error('localizacao')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Título -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Título da Vaga <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="titulo" id="titulo" minlength="3" required placeholder="Ex: Desenvolvedor Full Stack" value="{{ old('titulo') }}">
                                        @error('titulo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Descrição -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Descrição da Vaga <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="descricao" id="descricao" rows="8" required placeholder="Descrição completa da oportunidade, requisitos, benefícios, etc.">{{ old('descricao') }}</textarea>
                                        @error('descricao')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Salário, Datas e Link -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Faixa Salarial</label>
                                        <input type="text" class="form-control" name="salario" placeholder="Ex: R$ 3.000 - R$ 5.000" value="{{ old('salario') }}">
                                        <small class="form-text text-muted">Opcional</small>
                                        @error('salario')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Data de Publicação <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control datepicker" name="dt_publicacao" required value="{{ old('dt_publicacao', date('d/m/Y')) }}" placeholder="dd/mm/aaaa">
                                        @error('dt_publicacao')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Válida Até</label>
                                        <input type="text" class="form-control datepicker" name="dt_validade" value="{{ old('dt_validade') }}" placeholder="dd/mm/aaaa">
                                        <small class="form-text text-muted">Opcional</small>
                                        @error('dt_validade')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Link Externo</label>
                                        <input type="url" class="form-control" name="link_externo" placeholder="https://..." value="{{ old('link_externo') }}">
                                        <small class="form-text text-muted">Link para página externa de inscrição (opcional)</small>
                                        @error('link_externo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Arquivo e Status -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Anexar Arquivo</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="arquivo" name="arquivo" accept=".pdf,.doc,.docx">
                                            <label class="custom-file-label" for="arquivo">Escolher arquivo...</label>
                                        </div>
                                        <small class="form-text text-muted">Aceita PDF, DOC, DOCX (máx. 5MB)</small>
                                        @error('arquivo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Oportunidade Ativa?</label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="fl_ativo" value="1" {{ old('fl_ativo', 1) ? 'checked' : '' }}>
                                                <span class="form-check-sign">Sim</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <hr>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-round">
                                <i class="fa fa-save"></i> Salvar Oportunidade
                            </button>
                            <a href="{{ url('gercont/oportunidades') }}" class="btn btn-secondary btn-round">
                                <i class="fa fa-times"></i> Cancelar
                            </a>
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
$(document).ready(function() {
    // Inicializar datepicker
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        language: 'pt-BR',
        autoclose: true,
        todayHighlight: true
    });

    // Atualizar nome do arquivo selecionado
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).siblings('.custom-file-label').addClass("selected").html(fileName || 'Escolher arquivo...');
    });

    // Validação antes do envio
    $('#formOportunidade').on('submit', function(e) {
        var tipo = $('#tipo').val();
        var titulo = $('#titulo').val();
        var descricao = $('#descricao').val();
        var dt_publicacao = $('input[name="dt_publicacao"]').val();

        if (!tipo || !titulo || !descricao || !dt_publicacao) {
            e.preventDefault();
            Swal.fire({
                title: 'Atenção!',
                text: 'Preencha todos os campos obrigatórios.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return false;
        }
    });
});
</script>
@endsection
