@extends('layouts.app')
@section('content')
    <main id="main">
        <section id="services" class="services">
            <div class="container" data-aos="">
                <div class="section-title">
                    <h2 class="title">{{ $pagina->titulo }}</h2>
                    <p>{{ $pagina->subtitulo }}</p>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 icon-box" data-aos="fade-up">
                        {!! $pagina->text !!}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection