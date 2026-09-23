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

            <form action="{{ url('gercont/galeria') }}" method="GET" class="mb-4">
                <div class="input-group" style="max-width: 420px;">
                    <input type="search" name="q" class="form-control" value="{{ $busca ?? '' }}" placeholder="Buscar por título ou arquivo...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                        @if(!empty($busca))
                            <a href="{{ url('gercont/galeria') }}" class="btn btn-outline-secondary">Limpar</a>
                        @endif
                    </div>
                </div>
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
                                    <div class="input-group input-group-sm mb-2">
                                        <input type="text"
                                               class="form-control galeria-url"
                                               value="{{ $imagem->urlPublica() }}"
                                               readonly
                                               onclick="this.select()">
                                        <div class="input-group-append">
                                            <button type="button"
                                                    class="btn btn-outline-primary btn-copy-url"
                                                    data-url="{{ $imagem->urlPublica() }}"
                                                    title="Copiar URL">
                                                <i class="fa fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
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
}
.galeria-title {
    display: block;
    color: #284866;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}
.galeria-url {
    font-size: 0.72rem !important;
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
                var input = btn.closest('.input-group').find('.galeria-url')[0];
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
