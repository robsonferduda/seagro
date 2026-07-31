@extends('layouts.app')
@section('content')
    <main id="main">
        <section id="services" class="services">
            <div class="container" data-aos="">
                <div class="section-title">
                    <h2 class="title">Calendário SEAGRO-SC</h2>
                    <p>Confira todos os eventos do sindicato</p>
                </div>

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
                </div>

                <p class="evento-lista-actions">
                    <a href="{{ url('/') }}">Voltar para o Início</a>
                </p>
            </div>
        </section>
    </main>
@endsection
