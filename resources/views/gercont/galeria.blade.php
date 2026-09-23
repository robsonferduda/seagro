@extends('layouts.admin')
@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="card-title"><i class="fa fa-picture-o"></i> Galeria</h4>
                    <p class="text-muted mb-0"><small>Faça upload de imagens e copie a URL para inserir no corpo dos textos.</small></p>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('galeria/create') }}" class="btn btn-info pull-right ml-3"><i class="fa fa-upload"></i> Enviar imagens</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                @include('layouts.mensagens')
            </div>

            <form action="{{ url('gercont/galeria') }}" method="GET" class="galeria-busca mb-4">
                <input type="search"
                       name="q"
                       class="galeria-busca-input"
                       value="{{ $busca ?? '' }}"
                       placeholder="Buscar por título ou arquivo...">
                <button class="btn btn-primary galeria-busca-btn" type="submit" title="Buscar">
                    <i class="fa fa-search"></i>
                </button>
                @if(!empty($busca))
                    <a href="{{ url('gercont/galeria') }}" class="btn btn-default galeria-busca-btn">Limpar</a>
                @endif
            </form>

            @if($imagens->count())
                <div class="row galeria-grid">
                    @foreach($imagens as $imagem)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="galeria-card">
                                <div class="galeria-thumb">
                                    <img src="{{ $imagem->urlPublica() }}" alt="{{ $imagem->titulo }}">
                                </div>
                                <div class="galeria-card-body">
                                    <strong class="galeria-title" title="{{ $imagem->titulo }}">{{ \Illuminate\Support\Str::limit($imagem->titulo ?: $imagem->arquivo, 40) }}</strong>
                                    <small class="text-muted d-block mb-2">
                                        {{ $imagem->tamanhoFormatado() }}
                                        · {{ optional($imagem->created_at)->format('d/m/Y') }}
                                    </small>
                                    <div class="galeria-url-row">
                                        <input type="text"
                                               class="galeria-url"
                                               value="{{ $imagem->urlPublica() }}"
                                               readonly
                                               onclick="this.select()">
                                        <button type="button"
                                                class="btn btn-primary btn-sm btn-copy-url"
                                                data-url="{{ $imagem->urlPublica() }}"
                                                title="Copiar URL">
                                            <i class="fa fa-copy"></i>
                                        </button>
                                    </div>
                                    <div class="galeria-actions">
                                        <a href="{{ $imagem->urlPublica() }}" target="_blank" rel="noopener" class="btn btn-sm btn-link pl-0">
                                            <i class="fa fa-external-link"></i> Abrir
                                        </a>
                                        <form action="{{ route('galeria.destroy', $imagem->id) }}" method="POST" class="d-inline form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-link text-danger btn-remove" title="Excluir">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="fa fa-info-circle"></i>
                    @if(!empty($busca))
                        Nenhuma imagem encontrada para “{{ $busca }}”.
                    @else
                        Nenhuma imagem na galeria. Clique em <strong>Enviar imagens</strong> para começar.
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
.galeria-busca {
    display: flex;
    align-items: stretch;
    max-width: 460px;
    gap: 0;
}
.galeria-busca-input {
    flex: 1 1 auto;
    min-width: 0;
    height: 38px;
    padding: 0.45rem 0.75rem;
    border: 1px solid #ced4da;
    border-right: 0;
    border-radius: 4px 0 0 4px;
    font-size: 0.875rem;
    background: #fff;
    color: #495057;
}
.galeria-busca-input:focus {
    outline: none;
    border-color: #51cbce;
    box-shadow: none;
}
.galeria-busca-btn {
    flex: 0 0 auto;
    height: 38px;
    margin: 0 !important;
    border-radius: 0 !important;
    padding: 0 0.9rem;
}
.galeria-busca-btn:last-child {
    border-radius: 0 4px 4px 0 !important;
}

.galeria-card {
    background: #fff;
    border: 1px solid #e3e8ee;
    border-radius: 10px;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
}
.galeria-thumb {
    height: 160px;
    background: #f5f8fb;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.galeria-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.galeria-card-body {
    padding: 0.85rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.galeria-title {
    display: block;
    color: #284866;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
    word-break: break-word;
}
.galeria-url-row {
    display: flex;
    align-items: stretch;
    width: 100%;
    margin-bottom: 0.5rem;
}
.galeria-url {
    flex: 1 1 auto;
    min-width: 0;
    height: 32px;
    padding: 0.25rem 0.5rem;
    border: 1px solid #ced4da;
    border-right: 0;
    border-radius: 4px 0 0 4px;
    font-size: 0.7rem;
    background: #f8f9fa;
    color: #495057;
}
.galeria-url:focus {
    outline: none;
    border-color: #51cbce;
}
.galeria-url-row .btn-copy-url {
    flex: 0 0 36px;
    width: 36px;
    height: 32px;
    padding: 0;
    margin: 0 !important;
    border-radius: 0 4px 4px 0 !important;
    line-height: 30px;
}
.galeria-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}
</style>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('.btn-copy-url').on('click', function () {
            var url = $(this).data('url');
            var btn = $(this);

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(function () {
                    btn.html('<i class="fa fa-check"></i>');
                    setTimeout(function () { btn.html('<i class="fa fa-copy"></i>'); }, 1500);
                });
            } else {
                var input = btn.closest('.galeria-url-row').find('.galeria-url')[0];
                input.select();
                document.execCommand('copy');
                btn.html('<i class="fa fa-check"></i>');
                setTimeout(function () { btn.html('<i class="fa fa-copy"></i>'); }, 1500);
            }
        });

        $('.btn-remove').on('click', function (e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Excluir esta imagem?',
                html: '<strong>Atenção:</strong> o arquivo será removido do servidor. Links já inseridos em textos deixarão de funcionar.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check text-white"></i> Sim, excluir',
                confirmButtonColor: '#F64E60',
                cancelButtonText: 'Cancelar'
            }).then(function (result) {
                if (result.value) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
