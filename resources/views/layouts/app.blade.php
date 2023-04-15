<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Seagro</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('img/favicon.png') }}" rel="icon">
  <link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,600,600i,700,700i,900" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('vendor/animate.css/animate.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Template Main CSS File -->
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Mamba - v4.9.0
  * Template URL: https://bootstrapmade.com/mamba-one-page-bootstrap-template-free/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <section id="topbar" class="d-flex align-items-center" style="border-bottom: none; background-color: #0f1f2c;">
    <div class="container d-flex justify-content-center justify-content-md-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope-fill"></i><a href="mailto:contact@example.com">seagro@seagro-sc.org.br</a>
        <i class="bi bi-phone-fill phone-icon"></i> 48 3224-5681
      </div>
      <div class="social-links d-none d-md-block">
        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
      </div>
    </div>
  </section>

  <div style="background: #154166" class="d-none d-md-block d-lg-block">
  <div class="container">
  <section class="d-flex align-items-center" style="padding: 25px !important; background: #154166;">
    <div class="row" style=" position: relative;">
      <div class="col-md-12 d-none d-lg-block" style="min-height: 160px;">
        <a href="{{ url('/') }}"><img src="{{ asset('img/logo-seagro.png') }}" alt="" class="img-fluid" style="width: 160px; position: absolute;"></a>
        <h2 style="margin-left: 195px; color: #fff; margin-top: 45px;" class="d-none d-lg-block">SINDICATO DOS ENGENHEIROS AGRÔNOMOS DE SANTA CATARINA</h2>
        <p style="margin-left: 195px; color: #fff;" class="d-none d-lg-block">Desde 29 de abril de 1983 defendendo, representando, fortalecendo e valorizando a categoria</p>
      </div>
      <!--
      <div class="col-md-12 d-lg-none text-center" style="min-height: 160px;">
        <a href="{{ url('/') }}"><img src="{{ asset('img/logo-seagro.png') }}" alt="" class="img-fluid"></a>
      </div>
    -->
    </div>     
  </section>
  </div>
</div>

  <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex align-items-center">

      <div class="logo me-auto">
        <a href="{{ url('/') }}"><img src="{{ asset('img/logo-seagro.png') }}" alt="" class="img-fluid"></a>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li class="dropdown"><a href="#"><span>O Sindicato</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="{{ url('conteudo/apresentacao') }}">Apresentação</a></li>
              <li><a href="{{ url('conteudo/estrutura-organizacional') }}">Estrutura Organizacional</a></li>
              <li><a href="{{ url('conteudo/relatorios-financeiros') }}">Relatórios Financeiros</a></li>
            </ul>
          </li>
          <li><a class="nav-link scrollto" href="{{ url('conteudo/estatuto-social') }}">Estatuto Social</a></li>
          <li class="dropdown"><a href="#"><span>Diretoria</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="{{ url('conteudo/apresentacao') }}">Executiva</a></li>
              <li><a href="{{ url('conteudo/estrutura-organizacional') }}">Conselho Fiscal</a></li>
              <li><a href="{{ url('conteudo/relatorios-financeiros') }}">Regional</a></li>
              <li><a href="{{ url('conteudo/relatorios-financeiros') }}">Representante junto à Fisenge</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>Associado</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="{{ url('conteudo/apresentacao') }}">Atualização de Dados</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>Contribuições</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="{{ url('conteudo/apresentacao') }}">Sindical</a></li>
              <li><a href="{{ url('conteudo/apresentacao') }}">Social</a></li>
              <li><a href="{{ url('conteudo/apresentacao') }}">Assistencial</a></li>
            </ul>
          </li>
          <li class="dropdown"><a href="#"><span>Acordos e Convenções</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="{{ url('conteudo/apresentacao') }}">O que é ACT e CCT</a></li>
              <li><a href="{{ url('conteudo/apresentacao') }}">Empresas Publicas</a></li>
              <li><a href="{{ url('conteudo/apresentacao') }}">Empresas Privadas</a></li>
              <li><a href="{{ url('conteudo/apresentacao') }}">CREA-SC</a></li>
            </ul>
          </li>
          <li><a class="nav-link scrollto" href="{{ url('conteudo/campanha-salarial') }}">Campanha Salarial</a></li>
          <li><a class="nav-link scrollto" href="{{ url('conteudo/legislacao') }}">Legislação</a></li>
          <li><a class="nav-link scrollto" href="{{ url('conteudo/publicacoes') }}">Publicações</a></li>
          <li><a class="nav-link scrollto" href="#contact">Contato</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <main id="main">
  
    @yield('content')
    
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-info">
            <h3>Seagro-SC</h3>
            <p>
              Rua Adolfo Melo, 35 - Centro Executivo Via Veneto - Sala 1002 - Centro<br>
              Cep: 88.015-090 - Florianópolis/SC<br><br>
              <strong>Telefone:</strong> (48) 3224-5681<br>
              <strong>Email:</strong> seagro@seagro-sc.org.br<br>
            </p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>O Sindicato</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Apresentação</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Estrutura Organizacional</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Relatórios Finencairos</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Contribuições</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Sindical</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Social</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Assistencial</a></li>
            </ul>
          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Todos os direitos reservados <strong><span>SEAGRO-SC</span></strong> 2013
      </div>
      
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('js/main.js') }}"></script>

  <script type="text/javascript">
    $(document).ready(function(){

      alert("Teste");

    });
  </script>

</body>

</html>