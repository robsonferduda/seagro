@extends('layouts.app')
@section('content')
    <main id="main">
        <section id="services" class="services">
            <div class="container" data-aos="">
                <div class="section-title">
                    <h2 class="title">Calendário SEAGRO-SC</h2>
                    <p>Confira todos os eventos do sindicato</p>
                </div>
<<<<<<< HEAD

                <form action="{{ url('eventos/todos') }}" method="GET" class="evento-busca mb-4">
                    <div class="evento-busca-field">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <input type="search"
                               name="q"
                               value="{{ $busca ?? '' }}"
                               placeholder="Buscar evento por título ou descrição..."
                               aria-label="Buscar eventos"
                               autocomplete="off">
                        @if(!empty($busca))
                            <a href="{{ url('eventos/todos') }}" class="evento-busca-limpar" title="Limpar busca">
                                <i class="fa fa-times"></i>
                            </a>
                        @endif
                        <button type="submit">Buscar</button>
                    </div>
                </form>

                @if(!empty($busca))
                    <p class="evento-busca-resultado">
                        {{ $eventos->count() }}
                        {{ $eventos->count() === 1 ? 'resultado encontrado' : 'resultados encontrados' }}
                        para “{{ $busca }}”
                    </p>
                @endif

                <div class="evento-lista">
                    @forelse ($eventos as $evento)
                        @include('evento._item', ['evento' => $evento, 'showExcerpt' => true])
                    @empty
                        <p class="text-center text-muted mb-0">
                            @if(!empty($busca))
                                Nenhum evento encontrado para “{{ $busca }}”.
                            @else
                                Nenhum evento publicado no momento.
                            @endif
                        </p>
                    @endforelse
=======
                <div class="row">
                    @foreach ($eventos as $evento)
                        <div class="col-lg-12">
                            <div class="">               
                                <div class="pt-0">
                                    <div class="widget-49">
                                        <div class="widget-49-title-wrapper">
                                            <div class="widget-49-date-{{ $evento->ds_color ?: 'info' }}">
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
>>>>>>> c2699e2fe7d04111041bca749598cc75602164fe
                </div>

                <p class="evento-lista-actions">
                    <a href="{{ url('/') }}">Voltar para o Início</a>
                </p>
            </div>
        </section>
    </main>
@endsection
