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
                        @if($boletim->imagem)
                        <p>Ouça o conteúdo no player abaixo</p>
                        <audio controls>
                          <source src="horse.ogg" type="audio/ogg">
                          <source src="{{ url('boletim/'.$boletim->audio) }}" type="audio/mpeg">
                        Seu navegador não suporta arquivos de áudio
                        </audio><br/>
                        <p><a href="{{ url('boletim/download', $boletim->id) }}" class="forum-item-title">Clique aqui para baixar</a></p>
                        <p><img src="{{ url('boletim/'.$boletim->imagem) }}" width="100%"  alt=""></p>
                        @endif
                        {!! $boletim->texto !!}
                        <a href="{{ URL::previous() }}">Voltar para o Início</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection