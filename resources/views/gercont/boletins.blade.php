@extends('layouts.admin')
@section('content')
<div class="col-md-12 boletins-admin">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="card-title"><i class="fa fa-files-o"></i> Boletins</h4>
                    <p class="text-muted mb-0"><small>Boletins em PDF publicados na área de destaque do site.</small></p>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('boletim/create') }}" class="btn btn-info pull-right ml-3"><i class="fa fa-plus"></i> Cadastrar</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12 px-0">
                @include('layouts.mensagens')
            </div>

            <div class="bl-resumo">
                <div class="bl-resumo-item">
                    <strong>{{ $resumo['total'] }}</strong>
                    <span>Boletins</span>
                </div>
                <div class="bl-resumo-item tom-ok">
                    <strong>{{ $resumo['publicados'] }}</strong>
                    <span>Publicados</span>
                </div>
                <div class="bl-resumo-item tom-warn">
                    <strong>{{ $resumo['total'] - $resumo['publicados'] }}</strong>
                    <span>Ocultos</span>
                </div>
                <div class="bl-resumo-item tom-info">
                    <strong>{{ number_format($resumo['acessos'], 0, ',', '.') }}</strong>
                    <span>Acessos</span>
                </div>
                <div class="bl-resumo-item tom-info">
                    <strong>{{ number_format($resumo['downloads'], 0, ',', '.') }}</strong>
                    <span>Downloads</span>
                </div>
            </div>

            <div class="bl-filtros">
                <div class="bl-busca">
                    <i class="fa fa-search"></i>
                    <input type="search" id="blBusca" placeholder="Filtrar por título..." autocomplete="off">
                </div>
                <div class="bl-chips" id="blChips">
                    <button type="button" class="bl-chip ativo" data-filtro="todos">Todos</button>
                    <button type="button" class="bl-chip" data-filtro="publicados">Publicados</button>
                    <button type="button" class="bl-chip" data-filtro="ocultos">Ocultos</button>
                </div>
                <select id="blAno" class="bl-select" title="Ano">
                    <option value="">Todos os anos</option>
                    @foreach($anos as $ano)
                        <option value="{{ $ano }}">{{ $ano }}</option>
                    @endforeach
                </select>
            </div>

            <p class="bl-meta" id="blMeta"></p>

            <div class="bl-lista" id="blLista">
                @foreach($boletins as $boletim)
                    @php
                        $data = $boletim->dt_publicacao ? \Carbon\Carbon::parse($boletim->dt_publicacao) : null;
                        $imagem = $boletim->urlImagem();
                    @endphp
                    <div class="bl-item {{ $boletim->fl_publicacao ? '' : 'is-oculto' }}"
                         data-busca="{{ \Illuminate\Support\Str::lower(\Illuminate\Support\Str::ascii($boletim->titulo . ' ' . $boletim->subtitulo)) }}"
                         data-publicado="{{ $boletim->fl_publicacao ? 1 : 0 }}"
                         data-ano="{{ $data ? $data->format('Y') : '' }}">
                        <a href="{{ route('boletim.edit', $boletim->id) }}" class="bl-thumb" title="Editar">
                            @if($imagem)
                                <img src="{{ $imagem }}" alt="" loading="lazy" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                            @endif
                            <span class="bl-thumb-vazio" style="{{ $imagem ? 'display:none;' : '' }}"><i class="fa fa-file-pdf-o"></i></span>
                        </a>

                        <div class="bl-info">
                            <div class="bl-linha1">
                                <a href="{{ route('boletim.edit', $boletim->id) }}" class="bl-titulo">{{ $boletim->titulo }}</a>
                            </div>
                            @if($boletim->subtitulo)
                                <p class="bl-sub">{{ $boletim->subtitulo }}</p>
                            @endif
                            <div class="bl-badges">
                                @if($boletim->fl_publicacao)
                                    <span class="badge badge-success">Publicado</span>
                                @else
                                    <span class="badge badge-secondary">Oculto</span>
                                @endif
                                @if($boletim->arquivo)
                                    <a href="{{ asset('boletim/' . $boletim->arquivo) }}" target="_blank" rel="noopener" class="badge badge-light bl-arquivo" title="Abrir PDF"><i class="fa fa-file-pdf-o"></i> PDF</a>
                                @endif
                                @if($boletim->audio)
                                    <span class="badge badge-info"><i class="fa fa-volume-up"></i> Áudio</span>
                                @endif
                            </div>
                        </div>

                        <div class="bl-stats">
                            @if($data)
                                <span class="bl-data" title="{{ $data->format('d/m/Y') }}">
                                    <i class="fa fa-calendar"></i> {{ $data->format('d/m/Y') }}
                                    <small>{{ $data->locale('pt_BR')->diffForHumans() }}</small>
                                </span>
                            @endif
                            <span title="Acessos"><i class="fa fa-eye"></i> {{ number_format((int) $boletim->acessos, 0, ',', '.') }}</span>
                            <span title="Downloads"><i class="fa fa-download"></i> {{ number_format((int) $boletim->downloads, 0, ',', '.') }}</span>
                        </div>

                        <div class="bl-acoes">
                            <a href="{{ route('boletim.edit', $boletim->id) }}" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> Editar</a>
                            <a href="{{ url('boletim/detalhes', $boletim->dt_publicacao) }}" target="_blank" rel="noopener" class="btn btn-sm btn-default" title="Ver no site"><i class="fa fa-external-link"></i></a>
                            <a href="{{ url('boletim/publicacao/atualizar', $boletim->id) }}"
                               class="btn btn-sm {{ $boletim->fl_publicacao ? 'btn-warning btn-ocultar' : 'btn-success' }}"
                               data-titulo="{{ $boletim->titulo }}"
                               title="{{ $boletim->fl_publicacao ? 'Ocultar do site' : 'Publicar' }}">
                                <i class="fa {{ $boletim->fl_publicacao ? 'fa-eye-slash' : 'fa-check' }}"></i>
                            </a>
                            <form action="{{ route('boletim.destroy', $boletim->id) }}" method="POST" class="d-inline form-excluir" data-titulo="{{ $boletim->titulo }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Excluir"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="alert alert-info text-center mb-0 {{ $boletins->count() ? 'd-none' : '' }}" id="blVazio">
                <i class="fa fa-info-circle"></i>
                {{ $boletins->count() ? 'Nenhum boletim encontrado com esse filtro.' : 'Nenhum boletim cadastrado.' }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
.boletins-admin .card-body { padding-top: 1rem; }

.bl-resumo { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.25rem; }
.bl-resumo-item {
    flex: 1 1 120px;
    min-width: 110px;
    background: #f5f8fb;
    border: 1px solid #e3e8ee;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    text-align: center;
}
.bl-resumo-item strong { display: block; font-size: 1.35rem; color: #284866; line-height: 1.2; }
.bl-resumo-item span { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.03em; color: #6b7c8f; }
.bl-resumo-item.tom-ok strong { color: #1aae6f; }
.bl-resumo-item.tom-warn strong { color: #c77b16; }
.bl-resumo-item.tom-info strong { color: #336693; }

.bl-filtros { display: flex; flex-wrap: wrap; align-items: center; gap: 0.75rem 1rem; margin-bottom: 0.75rem; }
.bl-busca { position: relative; flex: 1 1 280px; max-width: 420px; }
.bl-busca i { position: absolute; left: 0.8rem; top: 50%; transform: translateY(-50%); color: #9aadb8; }
.bl-busca input {
    width: 100%;
    height: 38px;
    padding: 0.45rem 0.75rem 0.45rem 2.2rem;
    border: 1px solid #ced4da;
    border-radius: 20px;
    font-size: 0.875rem;
    background: #fff;
}
.bl-busca input:focus { outline: none; border-color: #51cbce; }
.bl-chips { display: flex; flex-wrap: wrap; gap: 0.4rem; }
.bl-chip {
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    border: 1px solid #d7dee8;
    background: #fff;
    color: #51657a;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
}
.bl-chip:hover { background: #f5f8fb; color: #284866; }
.bl-chip.ativo { background: #284866; border-color: #284866; color: #fff; }
.bl-select {
    margin-left: auto;
    height: 34px;
    border: 1px solid #d7dee8;
    border-radius: 6px;
    padding: 0 0.5rem;
    font-size: 0.8rem;
    color: #51657a;
    background: #fff;
}
.bl-meta { color: #6b7c8f; font-size: 0.85rem; margin-bottom: 1rem; }

.bl-lista { display: flex; flex-direction: column; gap: 0.65rem; }
.bl-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 1.1rem 0.75rem 0.75rem;
    background: #fff;
    border: 1px solid #e3e8ee;
    border-radius: 10px;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}
.bl-item:hover { border-color: #c5d3e0; box-shadow: 0 4px 14px rgba(40, 72, 102, 0.08); }
.bl-item.is-oculto { background: #fafbfc; }
.bl-item.is-oculto .bl-titulo { color: #7d8b99; }
.bl-item.is-oculto .bl-thumb img { filter: grayscale(0.7); opacity: 0.75; }
.bl-thumb {
    flex: 0 0 64px;
    width: 64px;
    height: 84px;
    border-radius: 6px;
    overflow: hidden;
    background: #eef3f8;
    border: 1px solid #e3e8ee;
}
.bl-thumb img { width: 100%; height: 100%; object-fit: cover; object-position: top; }
.bl-thumb-vazio { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #c0392b; font-size: 1.5rem; }
.bl-info { flex: 1 1 auto; min-width: 0; }
.bl-titulo {
    display: block;
    font-size: 1rem;
    font-weight: 700;
    color: #284866;
    line-height: 1.35;
    margin-bottom: 0.2rem;
    text-decoration: none !important;
}
.bl-titulo:hover { color: #336693; }
.bl-sub { margin: 0 0 0.3rem; color: #5a6d80; font-size: 0.85rem; }
.bl-badges { display: flex; flex-wrap: wrap; gap: 0.25rem; }
.bl-badges .badge { font-size: 0.68rem; padding: 0.35em 0.55em; }
.bl-arquivo { border: 1px solid #f1c6c1; color: #c0392b !important; text-decoration: none !important; }
.bl-stats { flex: 0 0 auto; display: flex; align-items: center; gap: 1.25rem; color: #6b7c8f; font-size: 0.8rem; white-space: nowrap; }
.bl-stats i { margin-right: 0.25rem; }
.bl-data small { display: block; font-size: 0.7rem; opacity: 0.85; padding-left: 1.05rem; }
.bl-acoes { flex: 0 0 auto; display: flex; gap: 0.35rem; }
.bl-acoes .btn { margin: 0 !important; }

@media (max-width: 991px) {
    .bl-item { flex-wrap: wrap; }
    .bl-info { flex-basis: calc(100% - 80px); }
    .bl-stats { flex: 1 1 auto; }
}
@media (max-width: 767px) {
    .bl-select { margin-left: 0; }
}
</style>
@endsection

@section('script')
<script>
$(document).ready(function () {
    var $itens = $('#blLista .bl-item');
    var total = $itens.length;
    var filtro = 'todos';

    function normalizar(texto) {
        return (texto || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }

    function aplicar() {
        if (!total) return;
        var termo = normalizar($.trim($('#blBusca').val()));
        var ano = $('#blAno').val();
        var visiveis = 0;

        $itens.each(function () {
            var $i = $(this);
            var ok = !termo || String($i.data('busca')).indexOf(termo) !== -1;
            if (ano) ok = ok && String($i.data('ano')) === ano;
            if (filtro === 'publicados') ok = ok && $i.data('publicado') == 1;
            if (filtro === 'ocultos') ok = ok && $i.data('publicado') == 0;
            $i.toggle(ok);
            if (ok) visiveis++;
        });

        $('#blVazio').toggleClass('d-none', visiveis > 0);
        $('#blMeta').text(visiveis === total
            ? 'Exibindo todos os ' + total + ' boletins, do mais recente para o mais antigo.'
            : 'Exibindo ' + visiveis + ' de ' + total + ' boletins.');
    }

    $('#blBusca').on('input', aplicar);
    $('#blAno').on('change', aplicar);
    $('#blChips').on('click', '.bl-chip', function () {
        filtro = $(this).data('filtro');
        $('#blChips .bl-chip').removeClass('ativo');
        $(this).addClass('ativo');
        aplicar();
    });

    function escapar(texto) {
        return $('<div>').text(texto || '').html();
    }

    $('#blLista').on('click', '.btn-ocultar', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
            title: 'Ocultar boletim do site?',
            html: '<strong>' + escapar($(this).data('titulo')) + '</strong>',
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

    $('#blLista').on('submit', '.form-excluir', function (e) {
        e.preventDefault();
        var form = this;
        Swal.fire({
            title: 'Excluir boletim?',
            html: '<strong>' + escapar($(form).data('titulo')) + '</strong><br><small>Os arquivos (PDF, imagem e áudio) serão removidos permanentemente.</small>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sim, excluir',
            cancelButtonText: 'Cancelar'
        }).then(function (result) {
            if (result.isConfirmed || result.value) {
                form.submit();
            }
        });
    });

    aplicar();
});
</script>
@endsection
