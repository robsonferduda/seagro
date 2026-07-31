@extends('layouts.admin')
@section('content')
<div class="col-md-12 dash-seagro">
    <div class="dash-hero">
        <div class="dash-hero-text">
            <h3 class="dash-hero-title">Central SEAGRO</h3>
            <p class="dash-hero-subtitle mb-0">
                Olá, {{ $usuarioNome }}. Hoje é {{ \Carbon\Carbon::now()->locale('pt_BR')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}.
            </p>
        </div>
        <div class="dash-hero-actions">
            <a href="{{ url('evento/create') }}" class="btn btn-sm dash-btn-primary">
                <i class="fa fa-plus"></i> Novo Evento
            </a>
            <a href="{{ url('noticia-admin/create') }}" class="btn btn-sm dash-btn-secondary">
                <i class="fa fa-plus"></i> Nova Notícia
            </a>
            <a href="{{ url('boletim/create') }}" class="btn btn-sm dash-btn-secondary">
                <i class="fa fa-plus"></i> Novo Boletim
            </a>
        </div>
    </div>

    <div class="row">
        @foreach($kpis as $kpi)
            <div class="col-lg-4 col-md-6">
                <a href="{{ $kpi['url'] }}" class="dash-kpi {{ $kpi['tom'] }}">
                    <div class="dash-kpi-icon"><i class="fa {{ $kpi['icone'] }}"></i></div>
                    <div class="dash-kpi-body">
                        <span class="dash-kpi-label">{{ $kpi['label'] }}</span>
                        <strong class="dash-kpi-value">{{ $kpi['valor'] }}</strong>
                        <span class="dash-kpi-detail">{{ $kpi['detalhe'] }}</span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    @if($alertas->count())
        <div class="dash-alerts">
            @foreach($alertas as $alerta)
                <a href="{{ $alerta['url'] }}" class="dash-alert dash-alert-{{ $alerta['nivel'] }}">
                    <i class="fa {{ $alerta['nivel'] === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle' }}"></i>
                    <span>{{ $alerta['texto'] }}</span>
                    <i class="fa fa-angle-right dash-alert-arrow"></i>
                </a>
            @endforeach
        </div>
    @endif

    <div class="row">
        <div class="col-lg-7">
            <div class="dash-panel">
                <div class="dash-panel-header">
                    <h4 class="dash-panel-title"><i class="fa fa-calendar"></i> Próximos eventos</h4>
                    <a href="{{ url('gercont/eventos') }}">Ver todos</a>
                </div>
                <div class="dash-panel-body">
                    @forelse($proximosEventos as $evento)
                        @php
                            $data = \Carbon\Carbon::parse($evento->data);
                            $tipoNome = optional($evento->tipo)->nm_tipo ?: 'Evento';
                        @endphp
                        <a href="{{ route('evento.edit', $evento) }}" class="dash-event-item">
                            <div class="dash-event-date">
                                <span class="dash-event-day">{{ $data->format('d') }}</span>
                                <span class="dash-event-month">{{ \App\Models\Utils::formataMes($data->format('m')) }}</span>
                            </div>
                            <div class="dash-event-body">
                                <div class="dash-event-meta">
                                    <span class="dash-badge">{{ mb_strtoupper($tipoNome, 'UTF-8') }}</span>
                                    @if($evento->isRedirect())
                                        <span class="dash-badge dash-badge-redirect">REDIRECT</span>
                                    @else
                                        <span class="dash-badge dash-badge-own">PRÓPRIA</span>
                                    @endif
                                    <span class="dash-event-fulldate">{{ $data->format('d/m/Y') }}</span>
                                </div>
                                <strong class="dash-event-title">{{ $evento->titulo }}</strong>
                            </div>
                            <i class="fa fa-angle-right dash-event-arrow"></i>
                        </a>
                    @empty
                        <p class="dash-empty mb-0">Nenhum evento futuro cadastrado.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="dash-panel">
                <div class="dash-panel-header">
                    <h4 class="dash-panel-title"><i class="fa fa-clock-o"></i> Atividade recente</h4>
                </div>
                <div class="dash-panel-body">
                    @forelse($atividadeRecente as $item)
                        <a href="{{ $item['url'] }}" class="dash-activity-item">
                            <div class="dash-activity-icon {{ $item['cor'] }}">
                                <i class="fa {{ $item['icone'] }}"></i>
                            </div>
                            <div class="dash-activity-body">
                                <span class="dash-activity-meta">{{ $item['meta'] }}</span>
                                <strong class="dash-activity-title">{{ \Illuminate\Support\Str::limit($item['titulo'], 70) }}</strong>
                                <span class="dash-activity-date">
                                    {{ \Carbon\Carbon::parse($item['data'])->diffForHumans() }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <p class="dash-empty mb-0">Nenhuma atividade recente.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="dash-panel">
        <div class="dash-panel-header">
            <h4 class="dash-panel-title"><i class="fa fa-th-large"></i> Atalhos de conteúdo</h4>
        </div>
        <div class="dash-panel-body">
            <div class="row">
                @foreach($atalhos as $atalho)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <a href="{{ $atalho['url'] }}" class="dash-shortcut {{ $atalho['tom'] }}">
                            <i class="fa {{ $atalho['icone'] }}"></i>
                            <span>{{ $atalho['label'] }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
