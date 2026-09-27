@extends('layouts.admin')
@section('content')
<div class="col-md-12 paginas-admin">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="card-title"><i class="fa fa-globe"></i> Páginas</h4>
                    <p class="text-muted mb-0"><small>Páginas institucionais do site e seus documentos anexados.</small></p>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('pagina-admin/create') }}" class="btn btn-info pull-right ml-3"><i class="fa fa-plus"></i> Cadastrar</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12 px-0">
                @include('layouts.mensagens')
            </div>

            <div class="pg-resumo">
                <div class="pg-resumo-item">
                    <strong>{{ $resumo['total'] }}</strong>
                    <span>Páginas</span>
                </div>
                <div class="pg-resumo-item tom-ok">
                    <strong>{{ $resumo['publicadas'] }}</strong>
                    <span>Publicadas</span>
                </div>
                <div class="pg-resumo-item tom-warn">
                    <strong>{{ $resumo['total'] - $resumo['publicadas'] }}</strong>
                    <span>Ocultas</span>
                </div>
                <div class="pg-resumo-item tom-info">
                    <strong>{{ $resumo['documentos'] }}</strong>
                    <span>Documentos</span>
                </div>
                <div class="pg-resumo-item tom-info">
                    <strong>{{ number_format($resumo['visitas'], 0, ',', '.') }}</strong>
                    <span>Visualizações</span>
                </div>
            </div>

            <div class="pg-filtros">
                <div class="pg-busca">
                    <i class="fa fa-search"></i>
                    <input type="search" id="pgBusca" placeholder="Filtrar por título ou endereço..." autocomplete="off">
                </div>
                <div class="pg-chips" id="pgChips">
                    <button type="button" class="pg-chip ativo" data-filtro="todas">Todas</button>
                    <button type="button" class="pg-chip" data-filtro="publicadas">Publicadas</button>
                    <button type="button" class="pg-chip" data-filtro="ocultas">Ocultas</button>
                    <button type="button" class="pg-chip" data-filtro="documentos"><i class="fa fa-paperclip"></i> Com documentos</button>
                </div>
                <select id="pgOrdem" class="pg-ordem" title="Ordenar">
                    <option value="atualizacao">Editadas recentemente</option>
                    <option value="titulo">Título (A–Z)</option>
                    <option value="visitas">Mais visualizadas</option>
                </select>
            </div>

            <p class="pg-meta" id="pgMeta"></p>

            <div class="pg-grid" id="pgGrid">
                @foreach($paginas as $pagina)
                    @php
                        $especial = array_key_exists($pagina->apelido, $layoutProprio);
                        $atualizada = $pagina->updated_at ?: $pagina->created_at;
                    @endphp
                    <div class="pg-card {{ $pagina->fl_publicacao ? '' : 'is-oculta' }}"
                         data-busca="{{ \Illuminate\Support\Str::lower(\Illuminate\Support\Str::ascii($pagina->titulo . ' ' . $pagina->apelido)) }}"
                         data-titulo="{{ \Illuminate\Support\Str::lower(\Illuminate\Support\Str::ascii($pagina->titulo)) }}"
                         data-publicada="{{ $pagina->fl_publicacao ? 1 : 0 }}"
                         data-documentos="{{ (int) $pagina->documentos_count }}"
                         data-visitas="{{ (int) $pagina->nu_visualizacoes }}"
                         data-atualizacao="{{ $atualizada ? $atualizada->timestamp : 0 }}">
                        <div class="pg-card-icone {{ $pagina->documentos_count ? 'com-docs' : '' }}">
                            <i class="fa {{ $pagina->documentos_count ? 'fa-folder-open' : ($especial ? 'fa-cube' : 'fa-file-text-o') }}"></i>
                        </div>

                        <div class="pg-card-info">
                            <div class="pg-card-linha1">
                                <a href="{{ url('pagina-admin/' . $pagina->id . '/edit') }}" class="pg-card-titulo">{{ $pagina->titulo }}</a>
                                <div class="pg-card-badges">
                                    @if($pagina->fl_publicacao)
                                        <span class="badge badge-success">Publicada</span>
                                    @else
                                        <span class="badge badge-secondary">Oculta</span>
                                    @endif
                                    @if($pagina->documentos_count)
                                        <span class="badge badge-info"><i class="fa fa-paperclip"></i> {{ $pagina->documentos_count }}</span>
                                    @endif
                                    @if($especial)
                                        <span class="badge badge-warning" title="O conteúdo desta página vem de um layout próprio; o texto editado aqui não aparece no site.">Layout próprio</span>
                                    @endif
                                </div>
                            </div>
                            <div class="pg-card-linha2">
                                <a href="{{ url('pagina/' . $pagina->apelido) }}" target="_blank" rel="noopener" class="pg-card-link">
                                    <i class="fa fa-link"></i> /pagina/{{ $pagina->apelido }}
                                </a>
                                @if($especial && $layoutProprio[$pagina->apelido])
                                    <a href="{{ $layoutProprio[$pagina->apelido] }}" class="pg-card-aviso"><i class="fa fa-info-circle"></i> Conteúdo gerenciado em outro menu</a>
                                @endif
                            </div>
                        </div>

                        <div class="pg-card-stats">
                            <span title="Visualizações"><i class="fa fa-eye"></i> {{ number_format((int) $pagina->nu_visualizacoes, 0, ',', '.') }}</span>
                            @if($atualizada)
                                <span title="Última edição: {{ $atualizada->format('d/m/Y H:i') }}"><i class="fa fa-clock-o"></i> {{ $atualizada->format('d/m/Y') }}</span>
                            @endif
                        </div>

                        <div class="pg-card-acoes">
                            <a href="{{ url('pagina-admin/' . $pagina->id . '/edit') }}" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> Editar</a>
                            <a href="{{ url('pagina/' . $pagina->apelido) }}" target="_blank" rel="noopener" class="btn btn-sm btn-default" title="Ver no site"><i class="fa fa-external-link"></i></a>
                            <a href="{{ url('pagina-admin/' . $pagina->id . '/toggle-publicacao') }}"
                               class="btn btn-sm {{ $pagina->fl_publicacao ? 'btn-warning btn-ocultar' : 'btn-success' }}"
                               data-titulo="{{ $pagina->titulo }}"
                               title="{{ $pagina->fl_publicacao ? 'Ocultar do site' : 'Publicar' }}">
                                <i class="fa {{ $pagina->fl_publicacao ? 'fa-eye-slash' : 'fa-check' }}"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="alert alert-info text-center mb-0 d-none" id="pgVazio">
                <i class="fa fa-info-circle"></i> Nenhuma página encontrada com esse filtro.
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
.paginas-admin .card-body { padding-top: 1rem; }

.pg-resumo { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.25rem; }
.pg-resumo-item {
    flex: 1 1 120px;
    min-width: 110px;
    background: #f5f8fb;
    border: 1px solid #e3e8ee;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    text-align: center;
}
.pg-resumo-item strong { display: block; font-size: 1.35rem; color: #284866; line-height: 1.2; }
.pg-resumo-item span { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.03em; color: #6b7c8f; }
.pg-resumo-item.tom-ok strong { color: #1aae6f; }
.pg-resumo-item.tom-warn strong { color: #c77b16; }
.pg-resumo-item.tom-info strong { color: #336693; }

.pg-filtros { display: flex; flex-wrap: wrap; align-items: center; gap: 0.75rem 1rem; margin-bottom: 0.75rem; }
.pg-busca { position: relative; flex: 1 1 280px; max-width: 420px; }
.pg-busca i { position: absolute; left: 0.8rem; top: 50%; transform: translateY(-50%); color: #9aadb8; }
.pg-busca input {
    width: 100%;
    height: 38px;
    padding: 0.45rem 0.75rem 0.45rem 2.2rem;
    border: 1px solid #ced4da;
    border-radius: 20px;
    font-size: 0.875rem;
    background: #fff;
}
.pg-busca input:focus { outline: none; border-color: #51cbce; }
.pg-chips { display: flex; flex-wrap: wrap; gap: 0.4rem; }
.pg-chip {
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    border: 1px solid #d7dee8;
    background: #fff;
    color: #51657a;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
}
.pg-chip:hover { background: #f5f8fb; color: #284866; }
.pg-chip.ativo { background: #284866; border-color: #284866; color: #fff; }
.pg-ordem {
    margin-left: auto;
    height: 34px;
    border: 1px solid #d7dee8;
    border-radius: 6px;
    padding: 0 0.5rem;
    font-size: 0.8rem;
    color: #51657a;
    background: #fff;
}
.pg-meta { color: #6b7c8f; font-size: 0.85rem; margin-bottom: 1rem; }

.pg-grid { display: flex; flex-direction: column; gap: 0.65rem; }
.pg-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.85rem 1.1rem;
    background: #fff;
    border: 1px solid #e3e8ee;
    border-radius: 10px;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}
.pg-card:hover { border-color: #c5d3e0; box-shadow: 0 4px 14px rgba(40, 72, 102, 0.08); }
.pg-card.is-oculta { background: #fafbfc; }
.pg-card.is-oculta .pg-card-titulo { color: #7d8b99; }
.pg-card-info { flex: 1 1 auto; min-width: 0; }
.pg-card-icone {
    flex: 0 0 40px;
    height: 40px;
    border-radius: 10px;
    background: #eef3f8;
    color: #336693;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}
.pg-card-icone.com-docs { background: #fff4e0; color: #c77b16; }
.pg-card-linha1 { display: flex; flex-wrap: wrap; align-items: center; gap: 0.4rem 0.6rem; margin-bottom: 0.15rem; }
.pg-card-badges { display: flex; flex-wrap: wrap; gap: 0.25rem; }
.pg-card-badges .badge { font-size: 0.68rem; padding: 0.35em 0.55em; }
.pg-card-titulo {
    font-size: 1rem;
    font-weight: 700;
    color: #284866;
    line-height: 1.35;
    text-decoration: none !important;
}
.pg-card-titulo:hover { color: #336693; }
.pg-card-linha2 { display: flex; flex-wrap: wrap; align-items: center; gap: 0.25rem 1rem; }
.pg-card-link {
    font-size: 0.78rem;
    color: #6b7c8f;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 100%;
}
.pg-card-link:hover { color: #336693; }
.pg-card-aviso { font-size: 0.75rem; color: #c77b16; }
.pg-card-stats { flex: 0 0 auto; display: flex; gap: 1.25rem; color: #6b7c8f; font-size: 0.8rem; white-space: nowrap; }
.pg-card-stats i { margin-right: 0.25rem; }
.pg-card-acoes { flex: 0 0 auto; display: flex; gap: 0.35rem; }
.pg-card-acoes .btn { margin: 0 !important; }

@media (max-width: 767px) {
    .pg-ordem { margin-left: 0; }
    .pg-card { flex-wrap: wrap; }
    .pg-card-info { flex-basis: calc(100% - 56px); }
    .pg-card-stats { flex: 1 1 auto; }
}
</style>
@endsection

@section('script')
<script>
$(document).ready(function () {
    var $grid = $('#pgGrid');
    var $cards = $grid.children('.pg-card');
    var total = $cards.length;
    var filtro = 'todas';

    function normalizar(texto) {
        return (texto || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }

    function ordenar() {
        var modo = $('#pgOrdem').val();
        var lista = $cards.get().sort(function (a, b) {
            var $a = $(a), $b = $(b);
            if (modo === 'titulo') {
                return String($a.data('titulo')).localeCompare(String($b.data('titulo')), 'pt-BR');
            }
            if (modo === 'visitas') {
                return $b.data('visitas') - $a.data('visitas');
            }
            return $b.data('atualizacao') - $a.data('atualizacao');
        });
        $grid.append(lista);
    }

    function aplicar() {
        var termo = normalizar($.trim($('#pgBusca').val()));
        var visiveis = 0;

        $cards.each(function () {
            var $c = $(this);
            var ok = !termo || String($c.data('busca')).indexOf(termo) !== -1;
            if (filtro === 'publicadas') ok = ok && $c.data('publicada') == 1;
            if (filtro === 'ocultas') ok = ok && $c.data('publicada') == 0;
            if (filtro === 'documentos') ok = ok && $c.data('documentos') > 0;
            $c.toggle(ok);
            if (ok) visiveis++;
        });

        $('#pgVazio').toggleClass('d-none', visiveis > 0);
        $('#pgMeta').text(visiveis === total
            ? 'Exibindo todas as ' + total + ' páginas.'
            : 'Exibindo ' + visiveis + ' de ' + total + ' páginas.');
    }

    $('#pgBusca').on('input', aplicar);

    $('#pgChips').on('click', '.pg-chip', function () {
        filtro = $(this).data('filtro');
        $('#pgChips .pg-chip').removeClass('ativo');
        $(this).addClass('ativo');
        aplicar();
    });

    $('#pgOrdem').on('change', ordenar);

    $grid.on('click', '.btn-ocultar', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
            title: 'Ocultar página do site?',
            html: '<strong>' + $('<div>').text($(this).data('titulo')).html() + '</strong><br>Quem acessar o endereço será levado à página inicial.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#c77b16',
            confirmButtonText: 'Sim, ocultar',
            cancelButtonText: 'Cancelar'
        }).then(function (result) {
            if (result.isConfirmed || result.value) {
                window.location = url;
            }
        });
    });

    aplicar();
});
</script>
@endsection
