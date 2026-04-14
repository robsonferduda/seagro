@extends('layouts.app')

@push('og_meta')
  <meta property="og:title" content="{{ $noticia->titulo }}" />
  <meta property="og:url" content="{{ url()->current() }}" />
  @if($noticia->img_capa)
    <meta property="og:image" content="{{ asset('img/noticias/' . $noticia->img_capa) }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
  @endif
  @if($noticia->subtitulo)
    <meta property="og:description" content="{{ $noticia->subtitulo }}" />
  @endif
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="{{ $noticia->titulo }}" />
  @if($noticia->img_capa)
    <meta name="twitter:image" content="{{ asset('img/noticias/' . $noticia->img_capa) }}" />
  @endif
@endpush

@section('content')
    <main id="main">
        <section id="services" class="services">
            <div class="container" data-aos="">
                <div class="section-title">
                    <h2 class="title">{{ $noticia->titulo }}</h2>
                    @if($noticia->subtitulo)
                        <p>{{ $noticia->subtitulo }}</p>
                    @endif

                    {{-- Metadados: data e visitas --}}
                    <div class="d-flex flex-wrap align-items-center gap-3 mt-2 mb-1 justify-content-center" style="font-size:14px; color:#6c757d;">
                        @if($noticia->dt_noticia)
                            <span><i class="bi bi-calendar3 me-1"></i>{{ \Carbon\Carbon::parse($noticia->dt_noticia)->format('d/m/Y') }}</span>
                        @endif
                        <span><i class="bi bi-eye me-1"></i>{{ number_format($noticia->num_visitas, 0, ',', '.') }} {{ $noticia->num_visitas == 1 ? 'visualização' : 'visualizações' }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 col-md-12 icon-box" data-aos="fade-up" style="text-align: justify;">
                        {!! $noticia->corpo !!}
                    </div>

                    {{-- Compartilhamento --}}
                    @php
                        $urlAtual = url()->current();
                        $tituloEncoded = urlencode($noticia->titulo);
                        $urlEncoded = urlencode($urlAtual);
                    @endphp
                    <div class="col-lg-12 col-md-12 icon-box mt-4">
                        <p class="mb-2" style="font-size:14px; color:#6c757d; font-weight:600;"><i class="bi bi-share me-1"></i>Compartilhar</p>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $urlEncoded }}"
                               target="_blank" rel="noopener"
                               class="btn btn-sm"
                               style="background-color:#1877f2; color:#fff; border-radius:6px;">
                                <i class="bi bi-facebook me-1"></i>Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ $tituloEncoded }}&url={{ $urlEncoded }}"
                               target="_blank" rel="noopener"
                               class="btn btn-sm"
                               style="background-color:#000; color:#fff; border-radius:6px;">
                                <i class="bi bi-twitter-x me-1"></i>X (Twitter)
                            </a>
                            <a href="https://api.whatsapp.com/send?text={{ $tituloEncoded }}%20{{ $urlEncoded }}"
                               target="_blank" rel="noopener"
                               class="btn btn-sm"
                               style="background-color:#25d366; color:#fff; border-radius:6px;">
                                <i class="bi bi-whatsapp me-1"></i>WhatsApp
                            </a>
                        </div>
                    </div>

                    {{-- Botão Voltar --}}
                    <div class="col-lg-12 col-md-12 icon-box mt-4">
                        <a href="{{ URL::previous() }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Voltar
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection