@extends('layouts.admin')
@section('content')
<div class="col-md-12 noticias-admin">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="card-title"><i class="fa fa-newspaper-o"></i> Notícias</h4>
                    <p class="text-muted mb-0"><small>Últimas publicações com busca para localizar o restante.</small></p>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('noticia-admin/create') }}" class="btn btn-info pull-right ml-3"><i class="fa fa-plus"></i> Cadastrar</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                @include('layouts.mensagens')
            </div>

            <div class="noticias-resumo">
                <div class="noticias-resumo-item">
                    <strong>{{ $resumo['total'] }}</strong>
                    <span>Total</span>
                </div>
                <div class="noticias-resumo-item tom-ok">
                    <strong>{{ $resumo['ativas'] }}</strong>
                    <span>Publicadas</span>
                </div>
                <div class="noticias-resumo-item tom-warn">
                    <strong>{{ $resumo['rascunho'] }}</strong>
                    <span>Rascunhos</span>
                </div>
                <div class="noticias-resumo-item tom-info">
                    <strong>{{ number_format($resumo['visitas'], 0, ',', '.') }}</strong>
                    <span>Visualizações</span>
                </div>
            </div>

            <form action="{{ url('gercont/noticias') }}" method="GET" class="noticias-filtros">
                <div class="noticias-busca">
                    <input type="search"
                           name="q"
                           class="noticias-busca-input"
                           value="{{ $busca ?? '' }}"
                           placeholder="Buscar por título, subtítulo ou URL...">
                    <button class="btn btn-primary noticias-busca-btn" type="submit" title="Buscar">
                        <i class="fa fa-search"></i>
                    </button>
                    @if(!empty($busca) || ($filtro ?? 'todas') !== 'todas')
                        <a href="{{ url('gercont/noticias') }}" class="btn btn-default noticias-busca-btn">Limpar</a>
                    @endif
                </div>
                <div class="noticias-status">
                    <a href="{{ url('gercont/noticias?' . http_build_query(array_filter(['q' => $busca ?: null, 'status' => 'todas']))) }}"
                       class="noticias-chip {{ ($filtro ?? 'todas') === 'todas' ? 'ativo' : '' }}">Todas</a>
                    <a href="{{ url('gercont/noticias?' . http_build_query(array_filter(['q' => $busca ?: null, 'status' => 'ativas']))) }}"
                       class="noticias-chip {{ ($filtro ?? '') === 'ativas' ? 'ativo' : '' }}">Publicadas</a>
                    <a href="{{ url('gercont/noticias?' . http_build_query(array_filter(['q' => $busca ?: null, 'status' => 'rascunho']))) }}"
                       class="noticias-chip {{ ($filtro ?? '') === 'rascunho' ? 'ativo' : '' }}">Rascunhos</a>
                </div>
            </form>

            <p class="noticias-meta">
                @if(!empty($busca))
                    {{ $noticias->count() }} resultado(s) para “{{ $busca }}”
                    @if($totalFiltrado > $noticias->count())
                        (exibindo {{ $limite }} de {{ $totalFiltrado }})
                    @endif
                @else
                    Exibindo as {{ $noticias->count() }} mais recentes
                    @if($totalFiltrado > $noticias->count())
                        de {{ $totalFiltrado }}
                    @endif
                    — use a busca para encontrar notícias anteriores.
                @endif
            </p>

            @forelse($noticias as $noticia)
                @php
                    $data = \Carbon\Carbon::parse($noticia->dt_noticia);
                    $excerpt = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($noticia->corpo ?? ''))), 160);
                    $capa = $noticia->img_capa
                        ? asset('img/noticias/' . $noticia->img_capa)
                        : null;
                @endphp
                <div class="noticia-item {{ $noticia->fl_ativa ? '' : 'is-draft' }}">
                    <div class="noticia-capa">
                        @if($capa)
                            <img src="{{ $capa }}" alt="">
                        @else
                            <div class="noticia-capa-empty"><i class="fa fa-image"></i></div>
                        @endif
                    </div>
                    <div class="noticia-corpo">
                        <div class="noticia-topo">
                            <div class="noticia-badges">
                                @if($noticia->fl_ativa)
                                    <span class="badge badge-success">Publicada</span>
                                @else
                                    <span class="badge badge-secondary">Rascunho</span>
                                @endif
                                @if($noticia->fl_banner)
                                    <span class="badge badge-info">Destaque / Banner</span>
                                @endif
                            </div>
                            <time class="noticia-data" datetime="{{ $data->format('Y-m-d') }}" title="{{ $data->format('d/m/Y H:i') }}">
                                {{ $data->format('d/m/Y') }}
                                <small>{{ $data->diffForHumans() }}</small>
                            </time>
                        </div>

                        <h5 class="noticia-titulo">{{ $noticia->titulo }}</h5>

                        @if($noticia->subtitulo)
                            <p class="noticia-sub">{{ $noticia->subtitulo }}</p>
                        @elseif($excerpt)
                            <p class="noticia-sub">{{ $excerpt }}</p>
                        @endif

                        <div class="noticia-stats">
                            <span title="Visualizações"><i class="fa fa-eye"></i> {{ number_format($noticia->num_visitas ?? 0, 0, ',', '.') }}</span>
                            @if($noticia->url)
                                <span title="URL amigável"><i class="fa fa-link"></i> /{{ \Illuminate\Support\Str::limit($noticia->url, 42) }}</span>
                            @endif
                        </div>

                        <div class="noticia-acoes">
                            <a href="{{ url('noticia/' . $noticia->url) }}" target="_blank" rel="noopener" class="btn btn-sm btn-default" title="Ver no site">
                                <i class="fa fa-external-link"></i> Ver
                            </a>
                            <a href="{{ url('noticia-admin/' . $noticia->id . '/edit') }}" class="btn btn-sm btn-info" title="Editar">
                                <i class="fa fa-pencil"></i> Editar
                            </a>
                            <a href="{{ url('noticia-admin/' . $noticia->id . '/toggle-ativa') }}"
                               class="btn btn-sm {{ $noticia->fl_ativa ? 'btn-warning' : 'btn-success' }}"
                               title="{{ $noticia->fl_ativa ? 'Despublicar' : 'Publicar' }}">
                                <i class="fa {{ $noticia->fl_ativa ? 'fa-eye-slash' : 'fa-check' }}"></i>
                                {{ $noticia->fl_ativa ? 'Despublicar' : 'Publicar' }}
                            </a>
                            <button type="button"
                                    class="btn btn-sm btn-danger btn-excluir"
                                    data-id="{{ $noticia->id }}"
                                    data-titulo="{{ e($noticia->titulo) }}"
                                    title="Excluir">
                                <i class="fa fa-trash"></i>
                            </button>
                            <form id="form-excluir-{{ $noticia->id }}" action="{{ url('noticia-admin/' . $noticia->id . '/destroy') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center mb-0">
                    <i class="fa fa-info-circle"></i>
                    @if(!empty($busca))
                        Nenhuma notícia encontrada para “{{ $busca }}”.
                    @else
                        Nenhuma notícia cadastrada.
                    @endif
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
.noticias-admin .card-body { padding-top: 1rem; }

.noticias-resumo {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
}
.noticias-resumo-item {
    flex: 1 1 120px;
    min-width: 110px;
    background: #f5f8fb;
    border: 1px solid #e3e8ee;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    text-align: center;
}
.noticias-resumo-item strong {
    display: block;
    font-size: 1.35rem;
    color: #284866;
    line-height: 1.2;
}
.noticias-resumo-item span {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    color: #6b7c8f;
}
.noticias-resumo-item.tom-ok strong { color: #1aae6f; }
.noticias-resumo-item.tom-warn strong { color: #c77b16; }
.noticias-resumo-item.tom-info strong { color: #336693; }

.noticias-filtros {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.75rem 1rem;
    margin-bottom: 0.75rem;
}
.noticias-busca {
    display: flex;
    align-items: stretch;
    flex: 1 1 320px;
    max-width: 520px;
}
.noticias-busca-input {
    flex: 1 1 auto;
    min-width: 0;
    height: 38px;
    padding: 0.45rem 0.75rem;
    border: 1px solid #ced4da;
    border-right: 0;
    border-radius: 4px 0 0 4px;
    font-size: 0.875rem;
    background: #fff;
}
.noticias-busca-input:focus {
    outline: none;
    border-color: #51cbce;
}
.noticias-busca-btn {
    flex: 0 0 auto;
    height: 38px;
    margin: 0 !important;
    border-radius: 0 !important;
    padding: 0 0.9rem;
}
.noticias-busca-btn:last-child {
    border-radius: 0 4px 4px 0 !important;
}
.noticias-status {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem;
}
.noticias-chip {
    display: inline-block;
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    border: 1px solid #d7dee8;
    background: #fff;
    color: #51657a;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none !important;
}
.noticias-chip:hover { background: #f5f8fb; color: #284866; }
.noticias-chip.ativo {
    background: #284866;
    border-color: #284866;
    color: #fff;
}

.noticias-meta {
    color: #6b7c8f;
    font-size: 0.85rem;
    margin-bottom: 1rem;
}

.noticia-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    margin-bottom: 0.85rem;
    background: #fff;
    border: 1px solid #e3e8ee;
    border-radius: 10px;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}
.noticia-item:hover {
    border-color: #c5d3e0;
    box-shadow: 0 4px 14px rgba(40, 72, 102, 0.08);
}
.noticia-item.is-draft {
    background: #fafbfc;
    opacity: 0.92;
}
.noticia-capa {
    flex: 0 0 140px;
    width: 140px;
    height: 100px;
    border-radius: 8px;
    overflow: hidden;
    background: #eef3f8;
}
.noticia-capa img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.noticia-capa-empty {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9aadb8;
    font-size: 1.6rem;
}
.noticia-corpo {
    flex: 1 1 auto;
    min-width: 0;
    display: flex;
    flex-direction: column;
}
.noticia-topo {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.35rem;
}
.noticia-badges .badge {
    margin-right: 0.25rem;
    font-size: 0.7rem;
    padding: 0.35em 0.55em;
}
.noticia-data {
    color: #6b7c8f;
    font-size: 0.8rem;
    white-space: nowrap;
}
.noticia-data small {
    display: block;
    text-align: right;
    opacity: 0.85;
}
.noticia-titulo {
    margin: 0 0 0.35rem;
    font-size: 1.05rem;
    font-weight: 700;
    color: #284866;
    line-height: 1.35;
}
.noticia-sub {
    margin: 0 0 0.5rem;
    color: #5a6d80;
    font-size: 0.88rem;
    line-height: 1.45;
}
.noticia-stats {
    display: flex;
    flex-wrap: wrap;
    gap: 0.85rem;
    color: #6b7c8f;
    font-size: 0.8rem;
    margin-bottom: 0.65rem;
}
.noticia-stats i { margin-right: 0.25rem; }
.noticia-acoes {
    display: flex;
    flex-wrap: wrap;
    gap: 0.35rem;
    margin-top: auto;
}
.noticia-acoes .btn {
    margin: 0 !important;
}

@media (max-width: 767px) {
    .noticia-item { flex-direction: column; }
    .noticia-capa {
        width: 100%;
        flex-basis: auto;
        height: 160px;
    }
    .noticia-data small { text-align: left; }
}
</style>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $(document).on('click', '.btn-excluir', function () {
            var id = $(this).data('id');
            var titulo = $(this).data('titulo');
            Swal.fire({
                title: 'Confirmar exclusão',
                html: 'Deseja excluir a notícia:<br><strong>' + titulo + '</strong>?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sim, excluir',
                cancelButtonText: 'Cancelar'
            }).then(function (result) {
                if (result.isConfirmed || result.value) {
                    $('#form-excluir-' + id).submit();
                }
            });
        });
    });
</script>
@endsection
