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
          <div class="row">
            <div class="col-lg-12 col-md-12 icon-box aos-init aos-animate center" data-aos="fade-up">
              <h5 class="mt-3"><a href="{{ url('noticias') }}">Todas as Notícias</a></h5>
            </div>
          </div>
      </div>
    </section>

    <section id="services" class="services">
      <div class="container" data-aos="">
        <div class="row">
          <div class="col-lg-3 col-md-6 icon-box" data-aos="fade-up">
            <a href="{{ url('pagina/fique-socio') }}">
              <div class="icon"><i class="fa fa-id-card-o"></i></div>
              <h4 class="title"><a href="{{ url('pagina/fique-socio') }}">Fique Sócio</a></h4>
              <p class="description">Baixe e preencha o formuládio de associação</p>
            </a>
          </div>
          <div class="col-lg-3 col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
            <div class="icon"><i class="fa fa-refresh"></i></div>
            <h4 class="title"><a href="https://sweb.diretasistemas.com.br/prosindweb/index.php?sind=617">Atualize Seus Dados</a></h4>
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
        
        <div class="row" style="margin-bottom: 15px;">
          
          <div class="col text-center">
            <a href="{{ url('pagina/eleicoes-2025') }}"> 
              <img src="{{ asset('img/banner/banner_eleicao.jpeg') }}" style="min-height: 230px" class="d-block w-100 img-radius" alt="Eleições SEAGRO-SC">
            </a>
          </div>

          <div class="col text-center">
            <a href="https://www.calameo.com/read/0024823218cec57041ed2"> 
              <img src="{{ asset('img/banner/revista_40_anos.jpg') }}" class="d-block w-100 img-radius" alt="Revista SEAGRO">
            </a>
          </div>
      
          <div class="col text-center">
            <a href=" {{ url('destaque/boletim') }}">
              <img src="{{ asset('img/banner/boletim.jpg') }}" class="d-block w-100 img-radius" alt="Boletins">
            </a>
          </div>
          <div class="col text-center">
            <a href=" {{ url('destaque/linha_do_tempo') }}">
              <img src="{{ asset('img/banner/linha_do_tempo.jpg') }}" class="d-block w-100 img-radius" alt="Linha do Tempo">
            </a>
          </div>
          <div class="col text-center">
            <a href=" {{ url('destaque/contribuicao-sindical') }}">
              <img src="{{ asset('img/banner/contribuicao_sindical.jpeg') }}" style="min-height: 230px" class="d-block w-100 img-radius" alt="Contribuição Sindical">
            </a>
          </div>
        </div>

      </div>
    </section>

    <section id="services" class="services destaques">
      <div class="section-title">
        <h2 class="title" style="font-size: 28px;">Vídeos SEAGRO-SC</h2>
      </div>
      <div class="container" data-aos="fade-up">
        <div class="row">
            @foreach ($videos as $video)
              <div class="col-lg-4 col-md-4 icon-box aos-init aos-animate" data-aos="fade-up">
                  <h6 style="min-height: 40px;">{{ $video->nm_video }}</h6>
                  @if($video->cd_tipo == 1)
                    <iframe width="100%" height="300" style="border-radius: 15px;" src="{{ $video->url }}?autoplay=0" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                  @else
                    <video width="100%" height="300"  style="border-radius: 15px;" controls>
                      <source src="{{ asset('videos/'.$video->url) }}" type="video/mp4">
                      <source src="movie.ogg" type="video/ogg">
                      Seu navegador não suporta a execução de vídeos
                    </video>
                  @endif
              </div>             
            @endforeach

            <div class="col-lg-12 col-md-12 icon-box aos-init aos-animate center" data-aos="fade-up">
                <h6><a href="{{ url('videos/todos') }}">Ver Todos</a></h6>
            </div>
        </div>
      </div>
    </section>

    <section id="services" class="services">
      <div class="container">
        <div class="section-title">
          <h2 class="title" style="font-size: 28px;">Calendário SEAGRO-SC</h2>
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
                                  <div class="widget-49-date-{{ ($evento->id_tipo == 1) ? 'success' : 'info' }}">
                                      <span class="widget-49-date-day">{{ \Carbon\Carbon::parse($evento->data)->format('d') }}</span>
                                      <span class="widget-49-date-month">{{ App\Models\Utils::formataMes(\Carbon\Carbon::parse($evento->data)->format('m')) }}</span>
                                  </div>
                                  <div class="widget-49-meeting-info mt-3">
                                      <span class="widget-49-pro-title"><a href="{{ url('eventos/detalhes',$evento->apelido) }}">{{ $evento->titulo }}</a></span>
                                      <span>{{ \Carbon\Carbon::parse($evento->data)->format('d/m/Y') }}</span>
                                      @if($evento->id_tipo == 1)
                                          <p style="">PRESENCIAL</p>
                                      @else
                                          <p style="">ONLINE</p>
                                      @endif
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
        
        <div class="row">

          <div col class="col-lg-6 col-md-6" data-aos="fade-up" style="text-align: center;">
            <div class="section-title">
            <h2 class="title" style="font-size: 28px;">Filiações</h2>
          </div>

            <div class="row">
              <div class="col-lg-6 col-md-6" data-aos="fade-up">
                <a href="https://fisenge.org.br" target="blank"><img src="{{ asset('img/logos/fisenge.jpg') }}" class="img-fluid" alt=""></a>
              </div>

              <div class="col-lg-6 col-md-6" data-aos="fade-up">
                <a href="http://www.dieese.org.br" target="blank"><img src="{{ asset('img/logos/dieese.jpg') }}" class="img-fluid" alt=""></a>
              </div>
            </div>
          </div>

          <div col class="col-lg-6 col-md-6" data-aos="fade-up" style="text-align: center;">
            <div class="section-title">
            <h2 class="title" style="font-size: 28px;">Entidades Parceiras</h2>
          </div>

            <div class="row">
              <div class="col-lg-6 col-md-6" data-aos="fade-up">
                <a href="https://www.feagrosc.org.br" target="blank"><img style="width: 32%;" src="{{ asset('img/logos/feagro.png') }}" class="img-fluid" alt=""></a>
              </div>

              <div class="col-lg-6 col-md-6" data-aos="fade-up">
                <a href="https://uneagro.com.br" target="blank"><img style="width: 40%;" src="{{ asset('img/logos/uneagro.png') }}" class="img-fluid" alt=""></a>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
    @include('contato')
  </main>
</div> 
@endsection