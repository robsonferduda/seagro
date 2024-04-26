@extends('layouts.app')
@section('content')
    <main id="main">
        <section id="services" class="services">
            <div class="container" data-aos="">
                <div class="section-title">
                    <h2 class="title">Todas as Notícias</h2>
                </div>
                <div class="row">
                    
                <p class="center"><a href="{{ URL::previous() }}">Voltar para o Início</a></p>
                </div>
            </div>
        </section>
    </main>
@endsection