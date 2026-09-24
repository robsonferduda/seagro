@extends('layouts.app')

@section('content')
<main id="main">
    <section class="noticias-page">
        <div class="container">
            <div class="noticias-page-header">
                <div>
                    <h1 class="noticias-page-title">Notícias</h1>
                    <p class="noticias-page-sub">Acompanhe as publicações do SEAGRO-SC</p>
                </div>
            </div>

            <form action="{{ url('noticias') }}" method="GET" class="noticias-page-filtros">
                <div class="noticias-page-busca">
                    <input type="search"
                           name="q"
                           value="{{ $busca ?? '' }}"
                           placeholder="Buscar por palavra..."
                           aria-label="Buscar notícias">
                </div>
                <div class="noticias-page-periodo">
                    <label>
                        <span>De</span>
                        <input type="date" name="de" value="{{ $de ?? '' }}" aria-label="Data inicial">
                    </label>
                    <label>
                        <span>Até</span>
                        <input type="date" name="ate" value="{{ $ate ?? '' }}" aria-label="Data final">
                    </label>
                </div>
                <div class="noticias-page-acoes">
                    <button type="submit" title="Buscar"><i class="bi bi-search"></i> Buscar</button>
                    @if(!empty($temFiltro))
                        <a href="{{ url('noticias') }}" class="noticias-page-limpar" title="Limpar filtros">Limpar</a>
                    @endif
                </div>
            </form>

            <p class="noticias-page-meta">
                @php
                    $partes = [];
                    if (!empty($busca)) {
                        $partes[] = '“' . $busca . '”';
                    }
                    if (!empty($de) || !empty($ate)) {
                        $deFmt = !empty($de) ? \Carbon\Carbon::parse($de)->format('d/m/Y') : '…';
                        $ateFmt = !empty($ate) ? \Carbon\Carbon::parse($ate)->format('d/m/Y') : '…';
                        $partes[] = 'período ' . $deFmt . ' a ' . $ateFmt;
                    }
                @endphp
                @if(!empty($temFiltro))
                    {{ $noticias->count() }} resultado(s)
                    @if(count($partes))
                        para {{ implode(' · ', $partes) }}
                    @endif
                    @if($total > $noticias->count())
                        · exibindo as {{ $limite }} mais recentes
                    @endif
                @else
                    Últimas {{ $noticias->count() }} publicações
                    @if($total > $noticias->count())
                        · use a busca ou o período para encontrar notícias anteriores
                    @endif
                @endif
            </p>

            @forelse($noticias as $index => $noticia)
                @php
                    $data = \Carbon\Carbon::parse($noticia->dt_noticia);
                    $excerpt = $noticia->subtitulo
                        ?: \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($noticia->corpo ?? ''))), 180);
                    $capa = $noticia->urlCapa();
                    $isDestaque = $index === 0 && empty($temFiltro);
                @endphp

                @if($isDestaque)
                    <a href="{{ url('noticia/' . $noticia->url) }}" class="noticia-destaque">
                        <div class="noticia-destaque-media">
                            @if($capa)
                                <img src="{{ $capa }}" alt="">
                            @else
                                <div class="noticia-sem-capa"><i class="bi bi-newspaper"></i></div>
                            @endif
                        </div>
                        <div class="noticia-destaque-body">
                            <time datetime="{{ $data->format('Y-m-d') }}">{{ $data->format('d/m/Y') }}</time>
                            <h2>{{ $noticia->titulo }}</h2>
                            @if($excerpt)
                                <p>{{ $excerpt }}</p>
                            @endif
                            <span class="noticia-ler">Ler notícia <i class="bi bi-arrow-right"></i></span>
                        </div>
                    </a>
                @else
                    <a href="{{ url('noticia/' . $noticia->url) }}" class="noticia-lista-item">
                        <div class="noticia-lista-capa">
                            @if($capa)
                                <img src="{{ $capa }}" alt="">
                            @else
                                <div class="noticia-sem-capa"><i class="bi bi-newspaper"></i></div>
                            @endif
                        </div>
                        <div class="noticia-lista-body">
                            <time datetime="{{ $data->format('Y-m-d') }}">{{ $data->format('d/m/Y') }}</time>
                            <h3>{{ $noticia->titulo }}</h3>
                            @if($excerpt)
                                <p>{{ $excerpt }}</p>
                            @endif
                        </div>
                    </a>
                @endif
            @empty
                <div class="noticias-vazio">
                    <i class="bi bi-info-circle"></i>
                    @if(!empty($temFiltro))
                        Nenhuma notícia encontrada
                        @if(!empty($busca) || !empty($de) || !empty($ate))
                            com os filtros informados.
                        @endif
                    @else
                        Nenhuma notícia publicada no momento.
                    @endif
                </div>
            @endforelse

            <div class="noticias-page-voltar">
                <a href="{{ url('/') }}"><i class="bi bi-arrow-left"></i> Voltar para o início</a>
            </div>
        </div>
    </section>
</main>

<style>
.noticias-page {
    --np-navy: #1f3548;
    --np-blue: #1c5c93;
    --np-muted: #5c768d;
    --np-border: #e3e8ee;
    --np-bg: #f5f9fc;
    padding: 2rem 0 3rem;
}
.noticias-page-header {
    margin-bottom: 1.25rem;
}
.noticias-page-title {
    margin: 0 0 0.25rem;
    font-size: 2rem;
    font-weight: 700;
    color: var(--np-navy);
}
.noticias-page-sub {
    margin: 0;
    color: var(--np-muted);
    font-size: 0.95rem;
}
.noticias-page-filtros {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    gap: 0.65rem 0.75rem;
    margin-bottom: 1rem;
    padding: 1rem;
    background: #fff;
    border: 1px solid var(--np-border);
    border-radius: 10px;
}
.noticias-page-busca {
    flex: 1 1 220px;
    min-width: 180px;
}
.noticias-page-busca input {
    width: 100%;
    height: 42px;
    border: 1px solid #cfd8e3;
    border-radius: 8px;
    padding: 0 0.85rem;
    font-size: 0.95rem;
    background: #fff;
}
.noticias-page-busca input:focus {
    outline: none;
    border-color: var(--np-blue);
}
.noticias-page-periodo {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}
.noticias-page-periodo label {
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
    margin: 0;
    font-size: 0.72rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    color: var(--np-muted);
}
.noticias-page-periodo input[type="date"] {
    height: 42px;
    border: 1px solid #cfd8e3;
    border-radius: 8px;
    padding: 0 0.65rem;
    font-size: 0.9rem;
    color: var(--np-navy);
    background: #fff;
    min-width: 150px;
}
.noticias-page-periodo input[type="date"]:focus {
    outline: none;
    border-color: var(--np-blue);
}
.noticias-page-acoes {
    display: flex;
    align-items: center;
    gap: 0.55rem;
}
.noticias-page-acoes button {
    height: 42px;
    border: 0;
    border-radius: 8px;
    background: var(--np-blue);
    color: #fff;
    padding: 0 1rem;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
}
.noticias-page-acoes button:hover {
    background: #164a76;
}
.noticias-page-limpar {
    color: var(--np-muted);
    font-size: 0.85rem;
    text-decoration: none;
    white-space: nowrap;
}
.noticias-page-limpar:hover { color: var(--np-blue); }
.noticias-page-meta {
    color: var(--np-muted);
    font-size: 0.88rem;
    margin-bottom: 1.5rem;
}

.noticia-destaque {
    display: grid;
    grid-template-columns: 1.15fr 1fr;
    gap: 0;
    margin-bottom: 1.5rem;
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
    border: 1px solid var(--np-border);
    text-decoration: none !important;
    color: inherit;
    transition: box-shadow .2s ease, transform .2s ease;
}
.noticia-destaque:hover {
    box-shadow: 0 10px 28px rgba(31, 53, 72, 0.12);
    transform: translateY(-2px);
}
.noticia-destaque-media {
    min-height: 280px;
    background: var(--np-bg);
}
.noticia-destaque-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.noticia-destaque-body {
    padding: 1.75rem 1.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.noticia-destaque-body time,
.noticia-lista-body time {
    display: inline-block;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--np-blue);
    letter-spacing: 0.02em;
    margin-bottom: 0.5rem;
}
.noticia-destaque-body h2 {
    margin: 0 0 0.75rem;
    font-size: 1.45rem;
    font-weight: 700;
    color: var(--np-navy);
    line-height: 1.3;
}
.noticia-destaque-body p,
.noticia-lista-body p {
    margin: 0;
    color: var(--np-muted);
    font-size: 0.95rem;
    line-height: 1.55;
}
.noticia-ler {
    margin-top: 1.15rem;
    font-weight: 600;
    color: var(--np-blue);
    font-size: 0.9rem;
}
.noticia-destaque:hover .noticia-ler { text-decoration: underline; }

.noticia-lista-item {
    display: flex;
    gap: 1.15rem;
    padding: 1rem;
    margin-bottom: 0.85rem;
    background: #fff;
    border: 1px solid var(--np-border);
    border-radius: 10px;
    text-decoration: none !important;
    color: inherit;
    transition: border-color .15s ease, box-shadow .15s ease;
}
.noticia-lista-item:hover {
    border-color: #b9c9d8;
    box-shadow: 0 6px 18px rgba(31, 53, 72, 0.08);
}
.noticia-lista-capa {
    flex: 0 0 160px;
    width: 160px;
    height: 110px;
    border-radius: 8px;
    overflow: hidden;
    background: var(--np-bg);
}
.noticia-lista-capa img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.noticia-lista-body {
    flex: 1;
    min-width: 0;
}
.noticia-lista-body h3 {
    margin: 0 0 0.4rem;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--np-navy);
    line-height: 1.35;
}
.noticia-sem-capa {
    width: 100%;
    height: 100%;
    min-height: 110px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9aadb8;
    font-size: 2rem;
    background: linear-gradient(135deg, #eef3f8, #f5f9fc);
}
.noticia-destaque-media .noticia-sem-capa {
    min-height: 280px;
    font-size: 3rem;
}

.noticias-vazio {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--np-muted);
    background: var(--np-bg);
    border-radius: 10px;
}
.noticias-page-voltar {
    margin-top: 2rem;
    text-align: center;
}
.noticias-page-voltar a {
    color: var(--np-muted);
    text-decoration: none;
    font-size: 0.95rem;
}
.noticias-page-voltar a:hover { color: var(--np-blue); }

@media (max-width: 991px) {
    .noticia-destaque {
        grid-template-columns: 1fr;
    }
    .noticia-destaque-media {
        min-height: 200px;
        max-height: 240px;
    }
}
@media (max-width: 575px) {
    .noticia-lista-item {
        flex-direction: column;
    }
    .noticia-lista-capa {
        width: 100%;
        flex-basis: auto;
        height: 160px;
    }
    .noticias-page-title { font-size: 1.6rem; }
}
</style>
@endsection
