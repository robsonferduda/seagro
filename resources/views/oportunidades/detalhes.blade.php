@extends('layouts.app')

@section('content')

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12 mb-3">
            <a href="{{ url('oportunidades') }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left"></i> Voltar para Oportunidades
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h3 class="card-title">{{ $oportunidade->titulo }}</h3>
                            <h5 class="text-muted">
                                <i class="fa fa-building"></i> {{ $oportunidade->empresa }}
                            </h5>
                        </div>
                        @if($oportunidade->tipo == 'Emprego')
                            <span class="badge badge-primary badge-pill" style="font-size: 1rem;">Emprego</span>
                        @elseif($oportunidade->tipo == 'Estágio')
                            <span class="badge badge-info badge-pill" style="font-size: 1rem;">Estágio</span>
                        @else
                            <span class="badge badge-secondary badge-pill" style="font-size: 1rem;">Freelance</span>
                        @endif
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="fa fa-map-marker text-primary"></i> Localização:</strong><br>
                                {{ $oportunidade->localizacao }}
                            </p>
                        </div>
                        @if($oportunidade->salario)
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong><i class="fa fa-money text-success"></i> Faixa Salarial:</strong><br>
                                    {{ $oportunidade->salario }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="fa fa-calendar text-info"></i> Publicado em:</strong><br>
                                {{ date('d/m/Y', strtotime($oportunidade->dt_publicacao)) }}
                            </p>
                        </div>
                        @if($oportunidade->dt_validade)
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong><i class="fa fa-clock-o {{ $oportunidade->isValida() ? 'text-success' : 'text-danger' }}"></i> Válida até:</strong><br>
                                    <span class="{{ $oportunidade->isValida() ? 'text-success' : 'text-danger' }}">
                                        {{ date('d/m/Y', strtotime($oportunidade->dt_validade)) }}
                                        @if(!$oportunidade->isValida())
                                            <strong>(Expirada)</strong>
                                        @endif
                                    </span>
                                </p>
                            </div>
                        @endif
                    </div>

                    <hr>

                    <h5 class="mb-3">Descrição da Vaga</h5>
                    <div class="descricao-vaga" style="white-space: pre-line;">
                        {{ $oportunidade->descricao }}
                    </div>

                    @if($oportunidade->arquivo || $oportunidade->link_externo)
                        <hr>
                        <div class="mt-4">
                            @if($oportunidade->arquivo)
                                <a href="{{ asset('oportunidades/'.$oportunidade->arquivo) }}" 
                                   class="btn btn-outline-primary mr-2 mb-2" target="_blank">
                                    <i class="fa fa-download"></i> Baixar Anexo
                                </a>
                            @endif

                            @if($oportunidade->link_externo)
                                <a href="{{ $oportunidade->link_externo }}" 
                                   class="btn btn-success mb-2" target="_blank">
                                    <i class="fa fa-external-link"></i> Candidatar-se
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm bg-light">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa fa-info-circle"></i> Informações
                    </h5>
                    <hr>
                    <p>
                        <small class="text-muted">
                            <i class="fa fa-eye"></i> Visualizações: <strong>{{ $oportunidade->visualizacoes }}</strong>
                        </small>
                    </p>

                    @if($oportunidade->isValida())
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle"></i> Vaga Ativa
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle"></i> Vaga Expirada
                        </div>
                    @endif

                    <hr>
                    
                    <h6 class="mb-3">Compartilhar</h6>
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                           class="btn btn-sm btn-primary mb-2 w-100" target="_blank">
                            <i class="fa fa-facebook"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($oportunidade->titulo) }}" 
                           class="btn btn-sm btn-info mb-2 w-100" target="_blank">
                            <i class="fa fa-twitter"></i> Twitter
                        </a>
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($oportunidade->titulo.' - '.url()->current()) }}" 
                           class="btn btn-sm btn-success w-100" target="_blank">
                            <i class="fa fa-whatsapp"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
