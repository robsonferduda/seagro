<div id="slide-top-left" class="carousel slide" data-bs-ride="carousel">
    <!-- Carousel indicators -->
    <ol class="carousel-indicators">
        <li data-bs-target="#slide-1" data-bs-slide-to="0" class="active" aria-current="true"></li>
        <li data-bs-target="#slide-1" data-bs-slide-to="1" class=""></li>
    </ol>
    
    <!-- Wrapper for carousel items -->
    <div class="carousel-inner">  
        @for($i = 5; $i < 7; $i++)
            <div class="carousel-item {{ ($i == 5) ? "active" : "" }}">
                <a href="{{ url('noticia', $noticias[$i]['url']) }}"><img src="{{ asset('img/noticias/'.$noticias[$i]['img_capa']) }}" class="d-block w-100" alt="Slide 2"></a>
                <div class="carousel-caption d-none d-md-block">
                    <h5></h5>
                    <p style="font-size: 12px;">{{ $noticias[$i]['titulo'] }}</p>
                </div>
            </div>
        @endfor 
    </div>

    <!-- Carousel controls -->
    <a class="carousel-control-prev" href="#slide-1" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#slide-1" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>