@if($itens->count())
<div id="{{ $id }}" class="carousel slide home-carrossel {{ $classe ?? '' }}" data-bs-ride="carousel">
    @if($itens->count() > 1)
        <div class="carousel-indicators">
            @foreach($itens as $i => $item)
                <button type="button" data-bs-target="#{{ $id }}" data-bs-slide-to="{{ $loop->index }}"
                        class="{{ $loop->first ? 'active' : '' }}" {!! $loop->first ? 'aria-current="true"' : '' !!}
                        aria-label="Slide {{ $loop->iteration }}"></button>
            @endforeach
        </div>
    @endif

    <div class="carousel-inner">
        @foreach($itens as $item)
            @php
                $capa = $item->urlCapa();
                $inteira = $item->ajusteCapa() === 'contain';
            @endphp
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <a href="{{ url('noticia', $item->url) }}" class="carrossel-quadro {{ $inteira ? 'is-contain' : '' }}">
                    @if($inteira)
                        <span class="carrossel-fundo" style="background-image: url('{{ $capa }}');" aria-hidden="true"></span>
                    @endif
                    <img src="{{ $capa }}" alt="{{ $item->titulo }}" {!! $loop->first ? '' : 'loading="lazy"' !!}>
                </a>
                <div class="carousel-caption d-none d-md-block">
                    <p @if(!empty($fonte)) style="font-size: {{ $fonte }};" @endif>{{ $item->titulo }}</p>
                </div>
            </div>
        @endforeach
    </div>

    @if($itens->count() > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#{{ $id }}" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#{{ $id }}" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Próximo</span>
        </button>
    @endif
</div>
@endif
