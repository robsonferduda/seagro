@extends('layouts.app')
@section('content')
<main id="main">
    <section style="padding: 10px 0;">
      <div class="container">
          <div class="row no-gutters">
                           

             
                <div class="col-lg-4" style="padding: 3px !important;">
      
                  @include("carrossel/pequeno_superior")
                  @include("carrossel/pequeno_inferior")
      
                
                  
                </div>
      
      
      
                <div class="col-lg-8" style="padding: 3px !important;">
                  @include("carrossel/grande")              
                </div>
              
          </div>
      </div>
    </section>

    <section id="services" class="services">
      <div class="container" data-aos="">
        <div class="row">
          <div class="col-lg-3 col-md-6 icon-box" data-aos="fade-up">
            <div class="icon"><i class="fa fa-id-card-o"></i></div>
            <h4 class="title"><a href="{{ url('pagina/fique-socio') }}">Fique Sócio</a></h4>
            <p class="description">Baixe e preencha o formuládio de associação</p>
          </div>
          <div class="col-lg-3 col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
            <div class="icon"><i class="fa fa-refresh"></i></div>
            <h4 class="title"><a href="">Atualize Seus Dados</a></h4>
            <p class="description">Mantenha seus dados atualizados</p>
          </div>
          <div class="col-lg-3 col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
            <div class="icon"><i class="fa fa-group"></i></div>
            <h4 class="title"><a href="">Imposto Sindical</a></h4>
            <p class="description">Acesse Aqui</p>
          </div>
          <div class="col-lg-3 col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
            <div class="icon"><i class="fa fa-check"></i></div>
            <h4 class="title"><a href="">Indique o Seagro-SC</a></h4>
            <p class="description">Quando preencher sua ART, indique o Seagro: COD 21</p>
          </div>
        </div>
        

      </div>
    </section>

    <section id="services" class="services destaques">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <div class="col-lg-3 col-md-6 text-center">
            <a href="https://www.calameo.com/read/0024823218cec57041ed2"> 
              <img src="{{ asset('img/banner/revista_40_anos.jpg') }}" class="d-block w-100 img-radius" alt="Slide 1">
            </a>
          </div>
          <div class="col-lg-3 col-md-6 text-center">
            <a href=" {{ url('destaque/boletim') }}">
              <img src="{{ asset('img/banner/boletim.jpg') }}" class="d-block w-100 img-radius" alt="Slide 1">
            </a>
          </div>
          <div class="col-lg-3 col-md-6 text-center">
            <a href=" {{ url('destaque/revista') }}">
              <img src="{{ asset('img/banner/linha_do_tempo.jpg') }}" class="d-block w-100 img-radius" alt="Slide 1">
            </a>
          </div>
          <div class="col-lg-3 col-md-6 text-center">
            <a href=" {{ url('destaque/contribuicao-sindical') }}">
              <img src="{{ asset('img/banner/contribuicao_sindical.jpg') }}" class="d-block w-100 img-radius" alt="Slide 1">
            </a>
          </div>
        </div>

      </div>
    </section>

    <section id="services" class="services">
      <div class="container">
        <div class="section-title">
          <h2 class="title" style="font-size: 28px;">Agenda de Cursos e Eventos</h2>
        </div>
        <div class="row">
          <div class="container">
            <div class="row">
              @foreach ($eventos as $evento)

                <div class="col-lg-12">
                  <div class="">               
                      <div class="pt-0">
                          <div class="widget-49">
                              <div class="widget-49-title-wrapper">
                                  <div class="widget-49-date-success">
                                      <span class="widget-49-date-day">27</span>
                                      <span class="widget-49-date-month">ABR</span>
                                  </div>
                                  <div class="widget-49-meeting-info mt-3">
                                      <span class="widget-49-pro-title"><a href="{{ url('eventos/detalhes',$evento->id) }}">{{ $evento->titulo }}</a></span>
                                      <span>{{ \Carbon\Carbon::parse($evento->data)->format('d/m/Y') }}</span>
                                      <p style="">PRESENCIAL</p>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
                  
              @endforeach
                               
             
            <div class="col-lg-12 text-center">
              <a href="{{ url('eventos') }}">Veja agenda completa</a>
            </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="services">
      <div class="container">
        <div class="section-title">
          <h2 class="title" style="font-size: 28px;">Filiações</h2>
        </div>
        <div class="row">

          <div class="col-lg-6 col-md-6" data-aos="fade-up" style="text-align: right;">
            <a href="https://fisenge.org.br" target="blank"><img src="{{ asset('img/logos/fisenge.jpg') }}" class="img-fluid" alt=""></a>
          </div>

          <div class="col-lg-6 col-md-6" data-aos="fade-up">
            <a href="http://www.dieese.org.br" target="blank"><img src="{{ asset('img/logos/dieese.jpg') }}" class="img-fluid" alt=""></a>
          </div>

        </div>
      </div>
    </section>
    @include('contato')
  </main>
</div> 
@endsection