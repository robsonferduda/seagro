@extends('layouts.app')
@section('content')
    <main id="main">
        <section id="services" class="services">
            <div class="container" data-aos="">
                <div class="section-title">
                    <h2 class="title">{{ $boletim->titulo }}</h2>
                    <p>{{ \Carbon\Carbon::parse($boletim->dt_publicacao)->format('d/m/Y') }}</p>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 icon-box" data-aos="fade-up">
                        
                        {!! $boletim->texto !!}
                        <a href="{{ URL::previous() }}">Voltar para o Início</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection