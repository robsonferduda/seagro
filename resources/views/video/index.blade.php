@extends('layouts.app')
@section('content')
    <main id="main">
        <section id="services" class="services">
            <div class="container" data-aos="">
                <div class="section-title">
                    <h2 class="title">Todas od Vídeos</h2>
                </div>
                <div class="row">
                    @foreach ($videos as $video)
                        <div class="col-lg-4 col-md-4 icon-box aos-init aos-animate" data-aos="fade-up">
                            <h6>{{ $video->nm_video }}</h6>
                            <iframe width="100%" height="300" src="{{ $video->url }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            <p>Postado em {{ \Carbon\Carbon::parse($video->dt_video)->format('d/m/Y') }}</p>
                        </div>             
                    @endforeach
                <p class="center"><a href="{{ URL::previous() }}">Voltar para o Início</a></p>
                </div>
            </div>
        </section>
    </main>
@endsection