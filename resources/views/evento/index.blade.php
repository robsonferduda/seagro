@extends('layouts.app')
@section('content')
    <main id="main">
        <section id="services" class="services">
            <div class="container" data-aos="">
                <div class="section-title">
                    <h2 class="title">Todos os Eventos</h2>
                </div>
                <div class="row">
                    @foreach ($eventos as $evento)
                        <div class="col-lg-12">
                            <div class="">               
                                <div class="pt-0">
                                    <div class="widget-49">
                                        <div class="widget-49-title-wrapper">
                                            <div class="widget-49-date-{{ ($evento->id_tipo == 1) ? 'success' : 'info' }}">
                                                <span class="widget-49-date-day">{{ \Carbon\Carbon::parse($evento->data)->format('d') }}</span>
                                                <span class="widget-49-date-month">{{ App\Models\Utils::formataMes(\Carbon\Carbon::parse($evento->data)->format('m')) }}</span>
                                            </div>
                                            <div class="widget-49-meeting-info mt-3">
                                                <span class="widget-49-pro-title"><a href="{{ url('eventos/detalhes',$evento->apelido) }}">{{ $evento->titulo }}</a></span>
                                                <span>{{ \Carbon\Carbon::parse($evento->data)->format('d/m/Y') }}</span>
                                                @if($evento->id_tipo == 1)
                                                    <p style="">PRESENCIAL</p>
                                                @else
                                                    <p style="">ONLINE</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                      
                    @endforeach
                  <p class="center"><a href="{{ URL::previous() }}">Voltar para o Início</a></p>
                </div>
            </div>
        </section>
    </main>
@endsection