@extends('layouts.app')
@section('content')

<main id="main">

    <section style="padding: 10px 0;">
      <div class="container">

        <div class="row no-gutters">
          <div class="col-lg-4" style="padding: 3px !important;">

            <div id="slide-1" class="carousel slide mb-1" data-bs-ride="carousel">
              <!-- Carousel indicators -->
              <ol class="carousel-indicators">
                  <li data-bs-target="#slide-1" data-bs-slide-to="0" class="active"></li>
                  <li data-bs-target="#slide-1" data-bs-slide-to="1"></li>
                  <li data-bs-target="#slide-1" data-bs-slide-to="2"></li>
              </ol>
              
              <!-- Wrapper for carousel items -->
              <div class="carousel-inner">
                  <div class="carousel-item active">
                      <img src="{{ asset('img/slides/foto-2.jpg') }}" class="d-block w-100" alt="Slide 1">
                      <div class="carousel-caption d-none d-md-block">
                          <h5>First slide label</h5>
                          <p>Some demonstrative placeholder content for the first slide.</p>
                      </div>
                  </div>
                  
              </div>
      
              <!-- Carousel controls -->
              <a class="carousel-control-prev" href="#slide-1" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon"></span>
              </a>
              <a class="carousel-control-next" href="#slide-1" data-bs-slide="next">
                  <span class="carousel-control-next-icon"></span>
              </a>
          </div>

          <div id="slide-1" class="carousel slide" data-bs-ride="carousel">
            <!-- Carousel indicators -->
            <ol class="carousel-indicators">
                <li data-bs-target="#slide-1" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#slide-1" data-bs-slide-to="1"></li>
                <li data-bs-target="#slide-1" data-bs-slide-to="2"></li>
            </ol>
            
            <!-- Wrapper for carousel items -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('img/slides/foto-3.jpg') }}" class="d-block w-100" alt="Slide 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>First slide label</h5>
                        <p>Some demonstrative placeholder content for the first slide.</p>
                    </div>
                </div>
                
            </div>
    
            <!-- Carousel controls -->
            <a class="carousel-control-prev" href="#slide-1" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#slide-1" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
            
          </div>
          <div class="col-lg-8" style="padding: 3px !important;">
            <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
              <!-- Carousel indicators -->
              <ol class="carousel-indicators">
                  <li data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"></li>
                  <li data-bs-target="#myCarousel" data-bs-slide-to="1"></li>
                  <li data-bs-target="#myCarousel" data-bs-slide-to="2"></li>
              </ol>
              
              <!-- Wrapper for carousel items -->
              <div class="carousel-inner">
                  <div class="carousel-item active">
                      <img src="{{ asset('img/slides/foto-1.jpg') }}" class="d-block w-100" alt="Slide 1">
                      <div class="carousel-caption d-none d-md-block">
                          <h5>First slide label</h5>
                          <p>Some demonstrative placeholder content for the first slide.</p>
                      </div>
                  </div>
                  <div class="carousel-item">
                      <img src="{{ asset('img/slides/foto-2.jpg') }}" class="d-block w-100" alt="Slide 2">
                      <div class="carousel-caption d-none d-md-block">
                          <h5>Second slide label</h5>
                          <p>Some demonstrative placeholder content for the second slide.</p>
                      </div>
                  </div>
                  <div class="carousel-item">
                      <img src="{{ asset('img/slides/foto-3.jpg') }}" class="d-block w-100" alt="Slide 3">
                      <div class="carousel-caption d-none d-md-block">
                          <h5>Third slide label</h5>
                          <p>Some demonstrative placeholder content for the third slide.</p>
                      </div>
                  </div>
              </div>
      
              <!-- Carousel controls -->
              <a class="carousel-control-prev" href="#myCarousel" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon"></span>
              </a>
              <a class="carousel-control-next" href="#myCarousel" data-bs-slide="next">
                  <span class="carousel-control-next-icon"></span>
              </a>
          </div>
        
          </div>
        </div>
      </div>
    </section>

    

    <section id="services" class="services">
      <div class="container" data-aos="fade-up">
        <div class="row">
          <div class="col-lg-3 col-md-6 icon-box" data-aos="fade-up">
            <div class="icon"><i class="fa fa-id-card-o"></i></div>
            <h4 class="title"><a href="{{ url('pagina/fique-socio') }}">Fique S??cio</a></h4>
            <p class="description">Baixe e preencha o formul??dio de associa????o</p>
          </div>
          <div class="col-lg-3 col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
            <div class="icon"><i class="fa fa-refresh"></i></div>
            <h4 class="title"><a href="">Atualize Seus Dados</a></h4>
            <p class="description">Mantenha seus dados atualizados</p>
          </div>
          <div class="col-lg-3 col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
            <div class="icon"><i class="fa fa-group"></i></div>
            <h4 class="title"><a href="">Imposto Sindical</a></h4>
            <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur</p>
          </div>
          <div class="col-lg-3 col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
            <div class="icon"><i class="fa fa-check"></i></div>
            <h4 class="title"><a href="">Indique o Seagro-SC</a></h4>
            <p class="description">Quando preencher sua ART, indique o Seagro: COD 21</p>
          </div>
        </div>

      </div>
    </section><!-- End Services Section -->

    <section id="services" class="services">
      <div class="container">
        <div class="section-title">
          <h2>Agenda de Cursos e Eventos</h2>
        </div>
        <div class="row">
          <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="">               
                        <div class="pt-0">
                            <div class="widget-49">
                                <div class="widget-49-title-wrapper">
                                    <div class="widget-49-date-primary">
                                        <span class="widget-49-date-day">15</span>
                                        <span class="widget-49-date-month">DEZ</span>
                                    </div>
                                    <div class="widget-49-meeting-info mt-3">
                                        <span class="widget-49-pro-title"><a href="">Elei????o Conselheiros junto ao CREA-SC</a></span>
                                        <span class="widget-49-meeting-time">15/12/2022 - 17:00</span>
                                        <p class="text-primary">ONLINE</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                  <div class="">               
                      <div class="pt-0">
                          <div class="widget-49">
                              <div class="widget-49-title-wrapper">
                                  <div class="widget-49-date-success">
                                      <span class="widget-49-date-day">28</span>
                                      <span class="widget-49-date-month">OUT</span>
                                  </div>
                                  <div class="widget-49-meeting-info mt-3">
                                      <span class="widget-49-pro-title"><a href="">Assembl??ia Geral</a></span>
                                      <span class="widget-49-meeting-time">28/10/2022 - 17:00</span>
                                      <p class="text-success">PRESENCIAL</p>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="col-lg-12">
                <div class="">               
                    <div class="pt-0">
                        <div class="widget-49">
                            <div class="widget-49-title-wrapper">
                                <div class="widget-49-date-primary">
                                    <span class="widget-49-date-day">06</span>
                                    <span class="widget-49-date-month">AGO</span>
                                </div>
                                <div class="widget-49-meeting-info mt-3">
                                    <span class="widget-49-pro-title"><a href="">Assembleia Geral Extraordin??ria Virtual - Negocia????es CONAB / FISENGE</a></span>
                                    <span class="widget-49-meeting-time">06/08/2022 - 17:00</span>
                                    <p class="text-primary">ONLINE</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section>
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 text-center" data-aos="fade-up">
            <a href="https://fisenge.org.br" target="blank"><img src="{{ asset('img/logos/fisenge.jpg') }}" class="img-fluid" alt=""></a>
          </div>

          <div class="col-lg-3 col-md-6 text-center" data-aos="fade-up">
            <a href="http://www.dieese.org.br" target="blank"><img src="{{ asset('img/logos/dieese.jpg') }}" class="img-fluid" alt=""></a>
          </div>

          <div class="col-lg-3 col-md-6 text-center" data-aos="fade-up">
            <a href="https://www.confea.org.br" target="blank"><img src="{{ asset('img/logos/confea.jpg') }}" class="img-fluid" alt=""></a>
          </div>

          <div class="col-lg-3 col-md-6 text-center" data-aos="fade-up">
            <a href="https://www.crea-sc.org.br" target="blank"><img src="{{ asset('img/logos/crea-sc.jpg') }}" class="img-fluid" alt=""></a>
          </div>

        </div>
      </div>
    </section>
    @include('contato')
  </main>
</div> 
@endsection