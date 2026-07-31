@extends('layouts.app')
@section('content')
    <main id="main">
        <section id="services" class="services">
            <div class="container" data-aos="">
                <div class="section-title">
                    <h2 class="title">{{ $evento->titulo }}</h2>
                    <p>{{ \Carbon\Carbon::parse($evento->data)->format('d/m/Y') }}</p>
                    @if(optional($evento->tipo)->nm_tipo)
                        <p class="mb-0"><span class="evento-item-badge">{{ mb_strtoupper($evento->tipo->nm_tipo, 'UTF-8') }}</span></p>
                    @endif
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 icon-box" data-aos="fade-up">
                        @if($evento->imagem)
                            @php
                                $ext = strtolower(pathinfo($evento->imagem, PATHINFO_EXTENSION));
                                $isPdf = $ext === 'pdf';
                            @endphp
                            <div class="mb-4 text-center">
                                @if($isPdf)
                                    <a href="{{ asset('img/eventos/'.$evento->imagem) }}" target="_blank" rel="noopener" class="btn btn-outline-primary">
                                        <i class="fa fa-file-pdf-o"></i> Abrir PDF do evento
                                    </a>
                                @else
                                    <img src="{{ asset('img/eventos/'.$evento->imagem) }}"
                                         alt="{{ $evento->titulo }}"
                                         class="img-fluid"
                                         style="max-width: 100%; border-radius: 8px;">
                                @endif
                            </div>
                        @endif

                        @if(!empty($evento->descricao))
                            <div class="evento-detalhe-conteudo">
                                {!! $evento->descricao !!}
                            </div>
                        @endif

                        <p class="mt-4">
                            <a href="{{ url('eventos/todos') }}">Voltar para o calendário</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
