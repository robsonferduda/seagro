<div id="slide-tbottm-left" class="carousel slide mb-1" data-bs-ride="carousel">
                    
    <ol class="carousel-indicators">
        <li data-bs-target="#slide-1" data-bs-slide-to="0" class="active" aria-current="true"></li>
        <li data-bs-target="#slide-1" data-bs-slide-to="1" class=""></li>
    </ol>              
    
    <div class="carousel-inner">

        @for($i = 3; $i < 5; $i++)
            <div class="carousel-item {{ ($i == 3) ? "active" : "" }}">
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