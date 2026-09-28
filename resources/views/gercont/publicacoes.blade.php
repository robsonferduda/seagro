@extends('layouts.admin')
@section('content')
<div class="col-md-12 publicacoes-admin">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="card-title"><i class="fa fa-book"></i> Publicações</h4>
                    <p class="text-muted mb-0"><small>Artigos, cartas, revistas e materiais listados na página <a href="{{ url('pagina/publicacoes') }}" target="_blank">Publicações</a> do site.</small></p>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('publicacao/create') }}" class="btn btn-info pull-right ml-3"><i class="fa fa-plus"></i> Cadastrar</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12 px-0">
                @include('layouts.mensagens')
            </div>

            <div class="pb-resumo">
                <div class="pb-resumo-item">
                    <strong>{{ $resumo['total'] }}</strong>
                    <span>Publicações</span>
                </div>
                <div class="pb-resumo-item tom-ok">
                    <strong>{{ $resumo['ativas'] }}</strong>
                    <span>Ativas</span>
                </div>
                <div class="pb-resumo-item tom-warn">
                    <strong>{{ $resumo['total'] - $resumo['ativas'] }}</strong>
                    <span>Inativas</span>
                </div>
                <div class="pb-resumo-item tom-info">
                    <strong>{{ $resumo['links'] }}</strong>
                    <span>Links externos</span>
                </div>
                <div class="pb-resumo-item tom-info">
                    <strong>{{ number_format($resumo['visitas'], 0, ',', '.') }}</strong>
                    <span>Visitas à página</span>
                </div>
            </div>

            <div class="pb-filtros">
                <div class="pb-busca">
                    <i class="fa fa-search"></i>
                    <input type="search" id="pbBusca" placeholder="Filtrar por título ou subtítulo..." autocomplete="off">
                </div>
                <div class="pb-chips" id="pbChips">
                    <button type="button" class="pb-chip ativo" data-filtro="todas">Todas</button>
                    <button type="button" class="pb-chip" data-filtro="ativas">Ativas</button>
                    <button type="button" class="pb-chip" data-filtro="inativas">Inativas</button>
                </div>
                <select id="pbOrdem" class="pb-select" title="Ordenar">
                    <option value="site">Ordem do site</option>
                    <option value="recentes">Cadastradas recentemente</option>
                    <option value="titulo">Título (A–Z)</option>
                </select>
            </div>

            <p class="pb-meta" id="pbMeta"></p>

            <div class="pb-lista" id="pbLista">
                @foreach($publicacoes as $indice => $publicacao)
                    @php
                        $link = $publicacao->linkPublico();
                        $extensao = $publicacao->extensao();
                        $externo = !empty($publicacao->link_externo);
                        $icone = $externo ? 'fa-link' : ($extensao === 'pdf' ? 'fa-file-pdf-o' : (in_array($extensao, ['doc', 'docx']) ? 'fa-file-word-o' : 'fa-file-o'));
                    @endphp
                    <div class="pb-item {{ $publicacao->fl_ativo ? '' : 'is-inativa' }}"
                         data-busca="{{ \Illuminate\Support\Str::lower(\Illuminate\Support\Str::ascii($publicacao->titulo . ' ' . $publicacao->subtitulo)) }}"
                         data-titulo="{{ \Illuminate\Support\Str::lower(\Illuminate\Support\Str::ascii($publicacao->titulo)) }}"
                         data-ativa="{{ $publicacao->fl_ativo ? 1 : 0 }}"
                         data-site="{{ $indice }}"
                         data-criacao="{{ $publicacao->created_at ? $publicacao->created_at->timestamp : 0 }}">
                        <div class="pb-ordem" title="Ordem no site">{{ $publicacao->nu_ordem }}</div>

                        <div class="pb-icone {{ $externo ? 'link' : $extensao }}">
                            <i class="fa {{ $icone }}"></i>
                        </div>

                        <div class="pb-info">
                            <a href="{{ route('publicacao.edit', $publicacao->id) }}" class="pb-titulo">{{ $publicacao->titulo }}</a>
                            @if($publicacao->subtitulo)
                                <p class="pb-sub">{{ $publicacao->subtitulo }}</p>
                            @endif
                            <div class="pb-badges">
                                @if($publicacao->fl_ativo)
                                    <span class="badge badge-success">Ativa</span>
                                @else
                                    <span class="badge badge-secondary">Inativa</span>
                                @endif
                                @if($link)
                                    <a href="{{ $link }}" target="_blank" rel="noopener" class="badge badge-light pb-arquivo" title="{{ $publicacao->link_externo ?: $publicacao->arquivo }}">
                                        <i class="fa {{ $externo ? 'fa-external-link' : 'fa-paperclip' }}"></i>
                                        {{ $externo ? 'Link externo' : strtoupper($extensao ?: 'arquivo') }}
                                    </a>
                                @else
                                    <span class="badge badge-danger">Sem arquivo</span>
                                @endif
                            </div>
                        </div>

                        <div class="pb-stats">
                            @if($publicacao->created_at)
                                <span title="Cadastrada em {{ $publicacao->created_at->format('d/m/Y H:i') }}"><i class="fa fa-calendar"></i> {{ $publicacao->created_at->format('d/m/Y') }}</span>
                            @endif
                        </div>

                        <div class="pb-acoes">
                            <a href="{{ route('publicacao.edit', $publicacao->id) }}" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> Editar</a>
                            @if($link)
                                <a href="{{ $link }}" target="_blank" rel="noopener" class="btn btn-sm btn-default" title="Abrir arquivo"><i class="fa fa-external-link"></i></a>
                            @endif
                            <a href="{{ url('publicacao/ativo/atualizar', $publicacao->id) }}"
                               class="btn btn-sm {{ $publicacao->fl_ativo ? 'btn-warning btn-desativar' : 'btn-success' }}"
                               data-titulo="{{ $publicacao->titulo }}"
                               title="{{ $publicacao->fl_ativo ? 'Desativar (ocultar do site)' : 'Ativar' }}">
                                <i class="fa {{ $publicacao->fl_ativo ? 'fa-eye-slash' : 'fa-check' }}"></i>
                            </a>
                            <form action="{{ route('publicacao.destroy', $publicacao->id) }}" method="POST" class="d-inline form-excluir" data-titulo="{{ $publicacao->titulo }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Excluir"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="alert alert-info text-center mb-0 {{ $publicacoes->count() ? 'd-none' : '' }}" id="pbVazio">
                <i class="fa fa-info-circle"></i>
                {{ $publicacoes->count() ? 'Nenhuma publicação encontrada com esse filtro.' : 'Nenhuma publicação cadastrada.' }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
.publicacoes-admin .card-body { padding-top: 1rem; }

.pb-resumo { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.25rem; }
.pb-resumo-item {
    flex: 1 1 120px;
    min-width: 110px;
    background: #f5f8fb;
    border: 1px solid #e3e8ee;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    text-align: center;
}
.pb-resumo-item strong { display: block; font-size: 1.35rem; color: #284866; line-height: 1.2; }
.pb-resumo-item span { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.03em; color: #6b7c8f; }
.pb-resumo-item.tom-ok strong { color: #1aae6f; }
.pb-resumo-item.tom-warn strong { color: #c77b16; }
.pb-resumo-item.tom-info strong { color: #336693; }

.pb-filtros { display: flex; flex-wrap: wrap; align-items: center; gap: 0.75rem 1rem; margin-bottom: 0.75rem; }
.pb-busca { position: relative; flex: 1 1 280px; max-width: 420px; }
.pb-busca i { position: absolute; left: 0.8rem; top: 50%; transform: translateY(-50%); color: #9aadb8; }
.pb-busca input {
    width: 100%;
    height: 38px;
    padding: 0.45rem 0.75rem 0.45rem 2.2rem;
    border: 1px solid #ced4da;
    border-radius: 20px;
    font-size: 0.875rem;
    background: #fff;
}
.pb-busca input:focus { outline: none; border-color: #51cbce; }
.pb-chips { display: flex; flex-wrap: wrap; gap: 0.4rem; }
.pb-chip {
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    border: 1px solid #d7dee8;
    background: #fff;
    color: #51657a;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
}
.pb-chip:hover { background: #f5f8fb; color: #284866; }
.pb-chip.ativo { background: #284866; border-color: #284866; color: #fff; }
.pb-select {
    margin-left: auto;
    height: 34px;
    border: 1px solid #d7dee8;
    border-radius: 6px;
    padding: 0 0.5rem;
    font-size: 0.8rem;
    color: #51657a;
    background: #fff;
}
.pb-meta { color: #6b7c8f; font-size: 0.85rem; margin-bottom: 1rem; }

.pb-lista { display: flex; flex-direction: column; gap: 0.65rem; }
.pb-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.85rem 1.1rem;
    background: #fff;
    border: 1px solid #e3e8ee;
    border-radius: 10px;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}
.pb-item:hover { border-color: #c5d3e0; box-shadow: 0 4px 14px rgba(40, 72, 102, 0.08); }
.pb-item.is-inativa { background: #fafbfc; }
.pb-item.is-inativa .pb-titulo { color: #7d8b99; }
.pb-ordem {
    flex: 0 0 30px;
    height: 30px;
    border-radius: 50%;
    background: #f5f8fb;
    border: 1px solid #e3e8ee;
    color: #6b7c8f;
    font-size: 0.78rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pb-icone {
    flex: 0 0 42px;
    height: 42px;
    border-radius: 10px;
    background: #eef3f8;
    color: #336693;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}
.pb-icone.pdf { background: #fdecec; color: #c0392b; }
.pb-icone.doc, .pb-icone.docx { background: #e8f0fd; color: #2b5797; }
.pb-icone.link { background: #eef0fd; color: #5b5fc7; }
.pb-info { flex: 1 1 auto; min-width: 0; }
.pb-titulo {
    display: block;
    font-size: 1rem;
    font-weight: 700;
    color: #284866;
    line-height: 1.35;
    margin-bottom: 0.2rem;
    text-decoration: none !important;
}
.pb-titulo:hover { color: #336693; }
.pb-sub { margin: 0 0 0.3rem; color: #5a6d80; font-size: 0.85rem; }
.pb-badges { display: flex; flex-wrap: wrap; gap: 0.25rem; }
.pb-badges .badge { font-size: 0.68rem; padding: 0.35em 0.55em; }
.pb-arquivo { border: 1px solid #d7dee8; color: #51657a !important; text-decoration: none !important; }
.pb-stats { flex: 0 0 auto; color: #6b7c8f; font-size: 0.8rem; white-space: nowrap; }
.pb-stats i { margin-right: 0.25rem; }
.pb-acoes { flex: 0 0 auto; display: flex; gap: 0.35rem; }
.pb-acoes .btn { margin: 0 !important; }

@media (max-width: 991px) {
    .pb-item { flex-wrap: wrap; }
    .pb-info { flex-basis: calc(100% - 130px); }
    .pb-stats { flex: 1 1 auto; }
}
@media (max-width: 767px) {
    .pb-select { margin-left: 0; }
}
</style>
@endsection

@section('script')
<script>
$(document).ready(function () {
    var $lista = $('#pbLista');
    var $itens = $lista.children('.pb-item');
    var total = $itens.length;
    var filtro = 'todas';

    function normalizar(texto) {
        return (texto || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }

    function escapar(texto) {
        return $('<div>').text(texto || '').html();
    }

    function ordenar() {
        var modo = $('#pbOrdem').val();
        var ordenados = $itens.get().sort(function (a, b) {
            var $a = $(a), $b = $(b);
            if (modo === 'titulo') return String($a.data('titulo')).localeCompare(String($b.data('titulo')), 'pt-BR');
            if (modo === 'recentes') return $b.data('criacao') - $a.data('criacao');
            return $a.data('site') - $b.data('site');
        });
        $lista.append(ordenados);
    }

    function aplicar() {
        if (!total) return;
        var termo = normalizar($.trim($('#pbBusca').val()));
        var visiveis = 0;

        $itens.each(function () {
            var $i = $(this);
            var ok = !termo || String($i.data('busca')).indexOf(termo) !== -1;
            if (filtro === 'ativas') ok = ok && $i.data('ativa') == 1;
            if (filtro === 'inativas') ok = ok && $i.data('ativa') == 0;
            $i.toggle(ok);
            if (ok) visiveis++;
        });

        $('#pbVazio').toggleClass('d-none', visiveis > 0);
        $('#pbMeta').text(visiveis === total
            ? 'Exibindo todas as ' + total + ' publicações.'
            : 'Exibindo ' + visiveis + ' de ' + total + ' publicações.');
    }

    $('#pbBusca').on('input', aplicar);
    $('#pbOrdem').on('change', ordenar);
    $('#pbChips').on('click', '.pb-chip', function () {
        filtro = $(this).data('filtro');
        $('#pbChips .pb-chip').removeClass('ativo');
        $(this).addClass('ativo');
        aplicar();
    });

    $lista.on('click', '.btn-desativar', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
            title: 'Desativar publicação?',
            html: '<strong>' + escapar($(this).data('titulo')) + '</strong><br><small>Ela deixará de aparecer na página Publicações do site.</small>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#c77b16',
            confirmButtonText: 'Sim, desativar',
            cancelButtonText: 'Cancelar'
        }).then(function (result) {
            if (result.isConfirmed || result.value) window.location = url;
        });
    });

    $lista.on('submit', '.form-excluir', function (e) {
        e.preventDefault();
        var form = this;
        Swal.fire({
            title: 'Excluir publicação?',
            html: '<strong>' + escapar($(form).data('titulo')) + '</strong><br><small>Esta ação não pode ser desfeita.</small>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sim, excluir',
            cancelButtonText: 'Cancelar'
        }).then(function (result) {
            if (result.isConfirmed || result.value) form.submit();
        });
    });

    aplicar();
});
</script>
@endsection
