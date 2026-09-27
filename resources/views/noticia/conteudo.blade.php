@extends('layouts.app')

@push('og_meta')
  <meta property="og:title" content="{{ $noticia->titulo }}" />
  <meta property="og:url" content="{{ url()->current() }}" />
  @if($noticia->img_capa)
    <meta property="og:image" content="{{ $noticia->urlCapa() }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
  @endif
  @if($noticia->subtitulo)
    <meta property="og:description" content="{{ $noticia->subtitulo }}" />
  @endif
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="{{ $noticia->titulo }}" />
  @if($noticia->img_capa)
    <meta name="twitter:image" content="{{ $noticia->urlCapa() }}" />
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
                    <div class="col-lg-12 col-md-12" data-aos="fade-up">
                        <div class="noticia-corpo">{!! $noticia->corpo !!}</div>
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

<style>
.noticia-corpo {
    display: flow-root;
    font-family: "Open Sans", sans-serif;
    font-size: 17px;
    line-height: 1.75;
    color: #333;
    text-align: justify;
    overflow-wrap: break-word;
}
.noticia-corpo p,
.noticia-corpo ul,
.noticia-corpo ol,
.noticia-corpo blockquote,
.noticia-corpo table {
    margin: 0 0 1rem;
}
.noticia-corpo h2,
.noticia-corpo h3,
.noticia-corpo h4 {
    margin: 1.75rem 0 0.75rem;
    line-height: 1.35;
    color: #1f3548;
    font-weight: 700;
    text-align: left;
}
.noticia-corpo h2 { font-size: 1.6rem; }
.noticia-corpo h3 { font-size: 1.35rem; }
.noticia-corpo h4 { font-size: 1.15rem; }
.noticia-corpo > :first-child { margin-top: 0; }

/* Parágrafos colados dentro de títulos (HTML inválido) voltam a parecer parágrafos */
.noticia-corpo h2 p,
.noticia-corpo h3 p,
.noticia-corpo h4 p {
    font-family: "Open Sans", sans-serif;
    font-weight: 400;
    color: #333;
    line-height: 1.75;
    text-align: justify;
}

.noticia-corpo ul,
.noticia-corpo ol { padding-left: 1.5rem; }
.noticia-corpo li { margin-bottom: 0.4rem; }
.noticia-corpo blockquote {
    padding: 0.75rem 1rem;
    border-left: 4px solid #1c5c93;
    background: #f5f9fc;
    color: #1f3548;
}
.noticia-corpo a { word-break: break-word; }

.noticia-corpo img {
    max-width: 100%;
    height: auto;
    border-radius: 6px;
}
.noticia-corpo img.note-float-right,
.noticia-corpo img[style*="float: right"],
.noticia-corpo img[style*="float:right"] {
    margin: 0.35rem 0 1.25rem 2rem;
}
.noticia-corpo img.note-float-left,
.noticia-corpo img[style*="float: left"],
.noticia-corpo img[style*="float:left"] {
    margin: 0.35rem 2rem 1.25rem 0;
}
.noticia-corpo img:not([style*="float"]) {
    display: block;
    margin: 1rem auto;
}

.noticia-corpo table {
    width: 100%;
    border-collapse: collapse;
}
.noticia-corpo td,
.noticia-corpo th {
    border: 1px solid #dde4ec;
    padding: 0.5rem 0.65rem;
}

@media (max-width: 767px) {
    .noticia-corpo { font-size: 16px; text-align: left; }
    .noticia-corpo img[style*="float"],
    .noticia-corpo img.note-float-right,
    .noticia-corpo img.note-float-left {
        float: none !important;
        width: 100% !important;
        display: block;
        margin: 0 0 1.25rem !important;
    }
}
</style>
@endsection