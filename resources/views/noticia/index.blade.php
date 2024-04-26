@extends('layouts.app')
@section('content')
    <main id="main">
        <section id="services" class="services">
            <div class="container" data-aos="">
                <div class="section-title">
                    <h2 class="title">Todas as Notícias</h2>
                </div>
                <div class="row">
                    @foreach ($noticias as $noticia)
                        <div class="col-lg-12">
                            <p><span>{{ \Carbon\Carbon::parse($noticia->dt_noticia)->format('d/m/Y') }}</span> - <a href="{{ url('noticia', $noticia->url) }}">{{ $noticia->titulo }}</a></p>             
                        </div>                      
                    @endforeach
                <p class="center"><a href="{{ URL::previous() }}">Voltar para o Início</a></p>
                </div>
            </div>
        </section>
    </main>
@endsection