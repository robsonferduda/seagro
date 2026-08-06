@extends('layouts.admin')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title">
                        <i class="fa fa-book"></i> Publicação
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i> Editar
                    </h4>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('gercont/publicacoes') }}" class="btn btn-info pull-right ml-3"><i class="fa fa-book"></i> Publicações</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                @include('layouts.mensagens')
            </div>
            <form method="POST" action="{{ route('publicacao.update', $publicacao->id) }}" enctype="multipart/form-data" id="formPublicacao">
                @csrf
                @method('PUT')
                @if($publicacao->arquivo)
                    <input type="hidden" name="arquivo_atual" value="{{ $publicacao->arquivo }}">
                @endif
                <div class="row px-3">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label>Título <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="titulo" required minlength="3" value="{{ old('titulo', $publicacao->titulo) }}">
                            @error('titulo') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Ordem</label>
                            <input type="number" class="form-control" name="nu_ordem" min="0" value="{{ old('nu_ordem', $publicacao->nu_ordem) }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Subtítulo <small class="text-muted">(opcional)</small></label>
                            <input type="text" class="form-control" name="subtitulo" value="{{ old('subtitulo', $publicacao->subtitulo) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Arquivo PDF/DOC</label>
                            @if($publicacao->arquivo)
                                <p class="mb-1">
                                    <small>Atual:
                                        <a href="{{ $publicacao->linkPublico() }}" target="_blank" rel="noopener">{{ $publicacao->arquivo }}</a>
                                    </small>
                                </p>
                            @endif
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="arquivo" id="arquivo" accept=".pdf,.doc,.docx">
                                <label class="custom-file-label" for="arquivo">Selecionar novo arquivo</label>
                            </div>
                            <small class="form-text text-muted">Deixe em branco para manter o arquivo atual.</small>
                            @error('arquivo') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ou link externo</label>
                            <input type="text" class="form-control" name="link_externo" value="{{ old('link_externo', $publicacao->link_externo) }}" placeholder="https://... ou /caminho/arquivo.pdf">
                            <small class="form-text text-muted">Se preenchido, tem prioridade na abertura do item.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Publicação ativa?</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="fl_ativo" value="1" {{ old('fl_ativo', $publicacao->fl_ativo) ? 'checked' : '' }}>
                                    <span class="form-check-sign">Sim</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mb-3 mt-3">
                    <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> Atualizar</button>
                    <a href="{{ url('gercont/publicacoes') }}" class="btn btn-danger btn-lg"><i class="fa fa-times"></i> Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $('.custom-file-input').on('change', function() {
            $(this).next('.custom-file-label').html($(this).val().split('\\').pop());
        });
    });
</script>
@endsection
