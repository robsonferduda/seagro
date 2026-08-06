@extends('layouts.app')
@section('content')
<main id="main">
    <section id="services" class="services">
        <div class="container" data-aos="">
            <div class="section-title">
                <h2 class="title">{{ $pagina->titulo ?? 'Publicações' }}</h2>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="publicacoes-lista">
                        @forelse($publicacoes as $publicacao)
                            <a href="{{ $publicacao->linkPublico() }}"
                               class="publicacao-item"
                               target="_blank"
                               rel="noopener">
                                <div class="publicacao-item-icon">
                                    <i class="fa fa-file-pdf-o"></i>
                                </div>
                                <div class="publicacao-item-body">
                                    <strong class="publicacao-item-title">{{ $publicacao->titulo }}</strong>
                                    @if($publicacao->subtitulo)
                                        <span class="publicacao-item-sub">{{ $publicacao->subtitulo }}</span>
                                    @endif
                                </div>
                                <div class="publicacao-item-action">
                                    <i class="fa fa-download"></i>
                                </div>
                            </a>
                        @empty
                            <p class="text-center text-muted">Nenhuma publicação disponível no momento.</p>
                        @endforelse
                    </div>
                    <p class="mt-4">
                        <a href="{{ url('/') }}">Voltar para o Início</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
.publicacoes-lista {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.publicacao-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.15rem;
    text-decoration: none !important;
    color: inherit;
    background: #fff;
    border: 1px solid #e3e8ee;
    border-left: 4px solid #336693;
    border-radius: 6px;
    transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
}
.publicacao-item:hover {
    border-color: #336693;
    box-shadow: 0 6px 18px rgba(51, 102, 147, 0.12);
    transform: translateY(-1px);
    color: inherit;
}
.publicacao-item-icon {
    width: 44px;
    height: 44px;
    border-radius: 8px;
    background: #edf3f8;
    color: #c0392b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex: 0 0 44px;
}
.publicacao-item-body {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
}
.publicacao-item-title {
    color: #284866;
    font-size: 1rem;
    line-height: 1.35;
}
.publicacao-item-sub {
    color: #7a8a99;
    font-size: 0.88rem;
}
.publicacao-item-action {
    color: #a0adb8;
    font-size: 1.1rem;
}
.publicacao-item:hover .publicacao-item-action {
    color: #336693;
}
</style>
@endsection
