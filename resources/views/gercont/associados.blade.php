@extends('layouts.admin')
@section('content')
<div class="col-md-12 associados-admin">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="card-title"><i class="fa fa-id-card-o"></i> Associados</h4>
                    <p class="text-muted mb-0"><small>Cadastros com acesso à <a href="{{ route('associado.login') }}" target="_blank">Área do Associado</a> do site.</small></p>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('associado-admin/create') }}" class="btn btn-info pull-right ml-3"><i class="fa fa-plus"></i> Cadastrar</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12 px-0">
                @include('layouts.mensagens')
            </div>

            <div class="asc-resumo">
                <div class="asc-resumo-item">
                    <strong>{{ $resumo['total'] }}</strong>
                    <span>Associados</span>
                </div>
                <div class="asc-resumo-item tom-ok">
                    <strong>{{ $resumo['ativos'] }}</strong>
                    <span>Com acesso liberado</span>
                </div>
                <div class="asc-resumo-item tom-erro">
                    <strong>{{ $resumo['total'] - $resumo['ativos'] }}</strong>
                    <span>Bloqueados</span>
                </div>
                <div class="asc-resumo-item tom-warn">
                    <strong>{{ $resumo['sem_senha'] }}</strong>
                    <span>Sem senha</span>
                </div>
                <div class="asc-resumo-item tom-info">
                    <strong>{{ $resumo['novos'] }}</strong>
                    <span>Novos (30 dias)</span>
                </div>
            </div>

            <div class="asc-filtros">
                <div class="asc-busca">
                    <i class="fa fa-search"></i>
                    <input type="search" id="ascBusca" placeholder="Filtrar por nome, CPF ou e-mail..." autocomplete="off">
                </div>
                <div class="asc-chips" id="ascChips">
                    <button type="button" class="asc-chip ativo" data-filtro="todos">Todos</button>
                    <button type="button" class="asc-chip" data-filtro="ativos">Liberados</button>
                    <button type="button" class="asc-chip" data-filtro="bloqueados">Bloqueados</button>
                    <button type="button" class="asc-chip" data-filtro="sem-senha">Sem senha</button>
                </div>
                <select id="ascOrdem" class="asc-select" title="Ordenar">
                    <option value="nome">Nome (A–Z)</option>
                    <option value="recentes">Cadastrados recentemente</option>
                    <option value="acesso">Último acesso</option>
                </select>
            </div>

            <p class="asc-meta" id="ascMeta"></p>

            <div class="asc-lista" id="ascLista">
                @foreach($associados as $associado)
                    @php
                        $partes = preg_split('/\s+/', trim($associado->nome));
                        $iniciais = mb_strtoupper(mb_substr($partes[0], 0, 1) . (count($partes) > 1 ? mb_substr(end($partes), 0, 1) : ''));
                    @endphp
                    <div class="asc-item {{ $associado->fl_ativo ? '' : 'is-bloqueado' }}"
                         data-busca="{{ \Illuminate\Support\Str::lower(\Illuminate\Support\Str::ascii($associado->nome . ' ' . $associado->email)) }} {{ $associado->cpf }} {{ $associado->cpfFormatado() }}"
                         data-nome="{{ \Illuminate\Support\Str::lower(\Illuminate\Support\Str::ascii($associado->nome)) }}"
                         data-ativo="{{ $associado->fl_ativo ? 1 : 0 }}"
                         data-senha="{{ $associado->temSenha() ? 1 : 0 }}"
                         data-criacao="{{ $associado->created_at ? $associado->created_at->timestamp : 0 }}"
                         data-acesso="{{ $associado->dt_ultimo_acesso ? $associado->dt_ultimo_acesso->timestamp : 0 }}">
                        <div class="asc-avatar">{{ $iniciais }}</div>

                        <div class="asc-info">
                            <a href="{{ url('associado-admin/' . $associado->id . '/edit') }}" class="asc-nome">{{ $associado->nome }}</a>
                            <p class="asc-sub">
                                <span><i class="fa fa-id-card-o"></i> {{ $associado->cpfFormatado() }}</span>
                                <span><i class="fa fa-envelope-o"></i> {{ $associado->email }}</span>
                            </p>
                            <div class="asc-badges">
                                @if($associado->fl_ativo)
                                    <span class="badge badge-success">Acesso liberado</span>
                                @else
                                    <span class="badge badge-danger">Bloqueado</span>
                                @endif
                                @unless($associado->temSenha())
                                    <span class="badge badge-warning" title="Ainda não criou a senha. Envie o link de acesso.">Sem senha</span>
                                @endunless
                                <span class="badge badge-light asc-origem">
                                    <i class="fa {{ $associado->origem === \App\Models\Associado::ORIGEM_SITE ? 'fa-globe' : 'fa-user-plus' }}"></i>
                                    {{ $associado->origem === \App\Models\Associado::ORIGEM_SITE ? 'Cadastro pelo site' : 'Cadastrado no painel' }}
                                </span>
                            </div>
                        </div>

                        <div class="asc-stats">
                            @if($associado->created_at)
                                <span title="Cadastrado em {{ $associado->created_at->format('d/m/Y H:i') }}"><i class="fa fa-calendar"></i> {{ $associado->created_at->format('d/m/Y') }}</span>
                            @endif
                            <span title="{{ $associado->dt_ultimo_acesso ? 'Último acesso em ' . $associado->dt_ultimo_acesso->format('d/m/Y H:i') : 'Nunca acessou' }}">
                                <i class="fa fa-sign-in"></i>
                                {{ $associado->dt_ultimo_acesso ? $associado->dt_ultimo_acesso->locale('pt_BR')->diffForHumans() : 'Nunca acessou' }}
                            </span>
                        </div>

                        <div class="asc-acoes">
                            <a href="{{ url('associado-admin/' . $associado->id . '/edit') }}" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> Editar</a>
                            @if($associado->fl_ativo)
                                <form action="{{ url('associado-admin/' . $associado->id . '/enviar-acesso') }}" method="POST" class="d-inline form-enviar" data-nome="{{ $associado->nome }}" data-email="{{ $associado->email }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-default" title="Enviar link para criar/redefinir senha"><i class="fa fa-envelope"></i></button>
                                </form>
                            @endif
                            <form action="{{ url('associado-admin/' . $associado->id . '/toggle-ativo') }}" method="POST" class="d-inline {{ $associado->fl_ativo ? 'form-bloquear' : '' }}" data-nome="{{ $associado->nome }}">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $associado->fl_ativo ? 'btn-warning' : 'btn-success' }}" title="{{ $associado->fl_ativo ? 'Bloquear acesso' : 'Liberar acesso' }}">
                                    <i class="fa {{ $associado->fl_ativo ? 'fa-ban' : 'fa-check' }}"></i>
                                </button>
                            </form>
                            <form action="{{ url('associado-admin/' . $associado->id . '/destroy') }}" method="POST" class="d-inline form-excluir" data-nome="{{ $associado->nome }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger" title="Excluir"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="alert alert-info text-center mb-0 {{ $associados->count() ? 'd-none' : '' }}" id="ascVazio">
                <i class="fa fa-info-circle"></i>
                {{ $associados->count() ? 'Nenhum associado encontrado com esse filtro.' : 'Nenhum associado cadastrado ainda.' }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
.associados-admin .card-body { padding-top: 1rem; }

.asc-resumo { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.25rem; }
.asc-resumo-item {
    flex: 1 1 120px;
    min-width: 110px;
    background: #f5f8fb;
    border: 1px solid #e3e8ee;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    text-align: center;
}
.asc-resumo-item strong { display: block; font-size: 1.35rem; color: #284866; line-height: 1.2; }
.asc-resumo-item span { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.03em; color: #6b7c8f; }
.asc-resumo-item.tom-ok strong { color: #1aae6f; }
.asc-resumo-item.tom-warn strong { color: #c77b16; }
.asc-resumo-item.tom-erro strong { color: #c0392b; }
.asc-resumo-item.tom-info strong { color: #336693; }

.asc-filtros { display: flex; flex-wrap: wrap; align-items: center; gap: 0.75rem 1rem; margin-bottom: 0.75rem; }
.asc-busca { position: relative; flex: 1 1 280px; max-width: 420px; }
.asc-busca i { position: absolute; left: 0.8rem; top: 50%; transform: translateY(-50%); color: #9aadb8; }
.asc-busca input {
    width: 100%;
    height: 38px;
    padding: 0.45rem 0.75rem 0.45rem 2.2rem;
    border: 1px solid #ced4da;
    border-radius: 20px;
    font-size: 0.875rem;
    background: #fff;
}
.asc-busca input:focus { outline: none; border-color: #51cbce; }
.asc-chips { display: flex; flex-wrap: wrap; gap: 0.4rem; }
.asc-chip {
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    border: 1px solid #d7dee8;
    background: #fff;
    color: #51657a;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
}
.asc-chip:hover { background: #f5f8fb; color: #284866; }
.asc-chip.ativo { background: #284866; border-color: #284866; color: #fff; }
.asc-select {
    margin-left: auto;
    height: 34px;
    border: 1px solid #d7dee8;
    border-radius: 6px;
    padding: 0 0.5rem;
    font-size: 0.8rem;
    color: #51657a;
    background: #fff;
}
.asc-meta { color: #6b7c8f; font-size: 0.85rem; margin-bottom: 1rem; }

.asc-lista { display: flex; flex-direction: column; gap: 0.65rem; }
.asc-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.85rem 1.1rem;
    background: #fff;
    border: 1px solid #e3e8ee;
    border-radius: 10px;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}
.asc-item:hover { border-color: #c5d3e0; box-shadow: 0 4px 14px rgba(40, 72, 102, 0.08); }
.asc-item.is-bloqueado { background: #fafbfc; }
.asc-item.is-bloqueado .asc-nome { color: #7d8b99; }
.asc-avatar {
    flex: 0 0 42px;
    height: 42px;
    border-radius: 50%;
    background: #eef3f8;
    color: #336693;
    font-weight: 700;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
}
.asc-item.is-bloqueado .asc-avatar { background: #fdecec; color: #c0392b; }
.asc-info { flex: 1 1 auto; min-width: 0; }
.asc-nome {
    display: block;
    font-size: 1rem;
    font-weight: 700;
    color: #284866;
    line-height: 1.35;
    margin-bottom: 0.15rem;
    text-decoration: none !important;
}
.asc-nome:hover { color: #336693; }
.asc-sub { margin: 0 0 0.3rem; color: #5a6d80; font-size: 0.83rem; display: flex; flex-wrap: wrap; gap: 0.2rem 1rem; }
.asc-sub i { color: #9aadb8; margin-right: 0.2rem; }
.asc-badges { display: flex; flex-wrap: wrap; gap: 0.25rem; }
.asc-badges .badge { font-size: 0.68rem; padding: 0.35em 0.55em; }
.asc-origem { border: 1px solid #d7dee8; color: #51657a !important; }
.asc-stats { flex: 0 0 auto; color: #6b7c8f; font-size: 0.8rem; white-space: nowrap; display: flex; flex-direction: column; gap: 0.2rem; text-align: right; }
.asc-stats i { margin-right: 0.25rem; }
.asc-acoes { flex: 0 0 auto; display: flex; gap: 0.35rem; }
.asc-acoes .btn { margin: 0 !important; }

@media (max-width: 991px) {
    .asc-item { flex-wrap: wrap; }
    .asc-info { flex-basis: calc(100% - 60px); }
    .asc-stats { flex: 1 1 auto; text-align: left; }
}
@media (max-width: 767px) {
    .asc-select { margin-left: 0; }
}
</style>
@endsection

@section('script')
<script>
$(document).ready(function () {
    var $lista = $('#ascLista');
    var $itens = $lista.children('.asc-item');
    var total = $itens.length;
    var filtro = 'todos';

    function normalizar(texto) {
        return (texto || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }

    function escapar(texto) {
        return $('<div>').text(texto || '').html();
    }

    function confirmar(form, opcoes) {
        Swal.fire($.extend({
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar'
        }, opcoes)).then(function (result) {
            if (result.isConfirmed || result.value) form.submit();
        });
    }

    function ordenar() {
        var modo = $('#ascOrdem').val();
        var ordenados = $itens.get().sort(function (a, b) {
            var $a = $(a), $b = $(b);
            if (modo === 'recentes') return $b.data('criacao') - $a.data('criacao');
            if (modo === 'acesso') return $b.data('acesso') - $a.data('acesso');
            return String($a.data('nome')).localeCompare(String($b.data('nome')), 'pt-BR');
        });
        $lista.append(ordenados);
    }

    function aplicar() {
        if (!total) return;
        var termo = normalizar($.trim($('#ascBusca').val()));
        var visiveis = 0;

        $itens.each(function () {
            var $i = $(this);
            var ok = !termo || String($i.data('busca')).indexOf(termo) !== -1;
            if (filtro === 'ativos') ok = ok && $i.data('ativo') == 1;
            if (filtro === 'bloqueados') ok = ok && $i.data('ativo') == 0;
            if (filtro === 'sem-senha') ok = ok && $i.data('senha') == 0;
            $i.toggle(ok);
            if (ok) visiveis++;
        });

        $('#ascVazio').toggleClass('d-none', visiveis > 0);
        $('#ascMeta').text(visiveis === total
            ? 'Exibindo todos os ' + total + ' associados.'
            : 'Exibindo ' + visiveis + ' de ' + total + ' associados.');
    }

    $('#ascBusca').on('input', aplicar);
    $('#ascOrdem').on('change', ordenar);
    $('#ascChips').on('click', '.asc-chip', function () {
        filtro = $(this).data('filtro');
        $('#ascChips .asc-chip').removeClass('ativo');
        $(this).addClass('ativo');
        aplicar();
    });

    $lista.on('submit', '.form-enviar', function (e) {
        e.preventDefault();
        confirmar(this, {
            icon: 'question',
            title: 'Enviar link de acesso?',
            html: 'Um e-mail será enviado para <strong>' + escapar($(this).data('email')) + '</strong> com um link para criar ou redefinir a senha.',
            confirmButtonColor: '#336693',
            confirmButtonText: 'Enviar'
        });
    });

    $lista.on('submit', '.form-bloquear', function (e) {
        e.preventDefault();
        confirmar(this, {
            title: 'Bloquear acesso?',
            html: '<strong>' + escapar($(this).data('nome')) + '</strong><br><small>O associado não conseguirá mais entrar na Área do Associado até ser liberado.</small>',
            confirmButtonColor: '#c77b16',
            confirmButtonText: 'Sim, bloquear'
        });
    });

    $lista.on('submit', '.form-excluir', function (e) {
        e.preventDefault();
        confirmar(this, {
            title: 'Excluir associado?',
            html: '<strong>' + escapar($(this).data('nome')) + '</strong><br><small>O cadastro e o acesso serão removidos. Esta ação não pode ser desfeita.</small>',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sim, excluir'
        });
    });

    aplicar();
});
</script>
@endsection
