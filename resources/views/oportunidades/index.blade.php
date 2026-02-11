@extends('layouts.app')

@section('content')

<div class="container mt-5 mb-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="text-primary">
                <i class="fa fa-briefcase"></i> Oportunidades
            </h2>
            <p class="lead">Confira as vagas disponíveis para associados</p>
        </div>
    </div>

    <div class="row">
        @if($oportunidades->count() > 0)
            @foreach($oportunidades as $oportunidade)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title mb-0">{{ $oportunidade->titulo }}</h5>
                                @if($oportunidade->tipo == 'Emprego')
                                    <span class="badge badge-primary badge-pill">Emprego</span>
                                @elseif($oportunidade->tipo == 'Estágio')
                                    <span class="badge badge-info badge-pill">Estágio</span>
                                @else
                                    <span class="badge badge-secondary badge-pill">Freelance</span>
                                @endif
                            </div>

                            <h6 class="text-muted mb-3">
                                <i class="fa fa-building"></i> {{ $oportunidade->empresa }}
                            </h6>

                            <div class="mb-2">
                                <small class="text-muted">
                                    <i class="fa fa-map-marker"></i> {{ $oportunidade->localizacao }}
                                </small>
                            </div>

                            @if($oportunidade->salario)
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fa fa-money"></i> {{ $oportunidade->salario }}
                                    </small>
                                </div>
                            @endif

                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fa fa-calendar"></i> Publicado em {{ date('d/m/Y', strtotime($oportunidade->dt_publicacao)) }}
                                </small>
                                @if($oportunidade->dt_validade)
                                    <br>
                                    <small class="{{ $oportunidade->isValida() ? 'text-success' : 'text-danger' }}">
                                        <i class="fa fa-clock-o"></i> Válida até {{ date('d/m/Y', strtotime($oportunidade->dt_validade)) }}
                                    </small>
                                @endif
                            </div>

                            <p class="card-text">
                                {{ Str::limit(strip_tags($oportunidade->descricao), 150) }}
                            </p>

                            <a href="{{ url('oportunidades/show', $oportunidade->id) }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-eye"></i> Ver Detalhes
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-12">
                <div class="alert alert-info text-center">
                    <i class="fa fa-info-circle fa-2x mb-3"></i>
                    <h5>Nenhuma oportunidade disponível no momento</h5>
                    <p>Volte mais tarde para conferir novas vagas!</p>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
