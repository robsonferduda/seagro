@extends('layouts.admin')
@section('content')
<div class="col-md-12 menus-admin">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="card-title"><i class="fa fa-list-ul"></i> Menus</h4>
                    <p class="text-muted mb-0"><small>Menus e submenus do site. A navbar pública ainda usa a estrutura fixa; este cadastro prepara a gestão.</small></p>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('gercont') }}" class="btn btn-warning pull-right ml-3 mr-3"><i class="nc-icon nc-chart-pie-36"></i> Dashboard</a>
                    <a href="{{ url('menu-admin/create') }}" class="btn btn-info pull-right ml-3"><i class="fa fa-plus"></i> Cadastrar</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="col-md-12 px-0">
                @include('layouts.mensagens')
            </div>

            <div class="mn-resumo">
                <div class="mn-resumo-item">
                    <strong>{{ $resumo['total'] }}</strong>
                    <span>Itens</span>
                </div>
                <div class="mn-resumo-item tom-ok">
                    <strong>{{ $resumo['ativos'] }}</strong>
                    <span>Ativos</span>
                </div>
                <div class="mn-resumo-item tom-warn">
                    <strong>{{ $resumo['inativos'] }}</strong>
                    <span>Inativos</span>
                </div>
                <div class="mn-resumo-item tom-info">
                    <strong>{{ $resumo['com_pagina'] }}</strong>
                    <span>Com página</span>
                </div>
                <div class="mn-resumo-item tom-info">
                    <strong>{{ $resumo['com_link'] }}</strong>
                    <span>Só link</span>
                </div>
            </div>

            @if($menus->isEmpty())
                <div class="alert alert-info text-center mb-0">
                    <i class="fa fa-info-circle"></i> Nenhum menu cadastrado. Clique em <strong>Cadastrar</strong> para criar o primeiro.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mn-table">
                        <thead>
                            <tr>
                                <th style="width:48px;">Ordem</th>
                                <th>Menu</th>
                                <th>Destino</th>
                                <th class="text-center" style="width:100px;">Status</th>
                                <th class="text-center" style="width:180px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menus as $menu)
                                @include('gercont.partials.menu_row', ['menu' => $menu, 'nivel' => 0])
                                @foreach($menu->filhos as $filho)
                                    @include('gercont.partials.menu_row', ['menu' => $filho, 'nivel' => 1])
                                    @foreach($filho->filhos as $neto)
                                        @include('gercont.partials.menu_row', ['menu' => $neto, 'nivel' => 2])
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
.menus-admin .card-body { padding-top: 1rem; }
.mn-resumo { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.25rem; }
.mn-resumo-item {
    flex: 1 1 110px;
    min-width: 100px;
    background: #f5f8fb;
    border: 1px solid #e3e8ee;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    text-align: center;
}
.mn-resumo-item strong { display: block; font-size: 1.35rem; color: #284866; line-height: 1.2; }
.mn-resumo-item span { font-size: 0.8rem; color: #6b7c8f; text-transform: uppercase; letter-spacing: 0.02em; }
.mn-resumo-item.tom-ok strong { color: #1e7e34; }
.mn-resumo-item.tom-warn strong { color: #c47d0e; }
.mn-resumo-item.tom-info strong { color: #1770a6; }
.mn-table td { vertical-align: middle; }
.mn-nome { font-weight: 600; color: #284866; }
.mn-indent { display: inline-block; color: #9aa8b6; margin-right: 0.35rem; }
.mn-destino { font-size: 0.9rem; }
.mn-destino a { color: #1770a6; }
.mn-destino .text-muted { font-size: 0.85rem; }
.mn-acoes .btn { margin: 0 0.15rem 0.15rem 0; }
.mn-acoes form { display: inline; }
</style>
@endsection
