<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="base-url" content="{{ env('BASE_URL') }}">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link href="images/favicon.png" rel="shortcut icon">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>{{ config('app.name', 'Studio Clipagem') }}</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
   <!--     Fonts and icons     -->
   <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
   <!-- CSS Files -->
   <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
   <link href="{{ asset('css/paper-dashboard.css?v=2.0.1') }}" rel="stylesheet" />
   <!-- CSS Just for demo purpose, don't include it in your project -->
   <link href="{{ asset('demo/demo.css') }}" rel="stylesheet" />
   <link href="{{ asset('css/custom_admin.css') }}" rel="stylesheet" />
   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  @yield('style')
</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="white" data-active-color="danger">
            <div class="logo">
                <a style="padding-left: 8px;" href="{{ url('perfil') }}" class="simple-text logo-normal">
                  <i class="fa fa-user"></i> {{ (Auth::user()) ? explode(" ", Auth::user()->name)[0] : 'Não identificado' }}
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                <li class="{{ (Session::has('url') and Session::get('url') == 'gercont') ? 'active' : '' }}">
                    <a href="{{ url('gercont') }}">
                    <i class="nc-icon nc-chart-pie-36"></i>
                    <p>Dashboard</p>
                    </a>
                </li>
                <li class="{{ (Session::has('url') and Session::get('url') == 'boletins') ? 'active' : '' }}">
                  <a href="{{ url('gercont/boletins') }}">
                    <i class="fa fa-files-o"></i>
                      <p>Boletins</p>
                  </a>
                </li>
                <li class="{{ (Session::has('url') and Session::get('url') == 'eventos') ? 'active' : '' }}">
                  <a href="{{ url('gercont/eventos') }}">
                    <i class="nc-icon nc-tag-content"></i>
                      <p>Eventos</p>
                  </a>
                </li>
                <li class="{{ (Session::has('url') and Session::get('url') == 'paginas') ? 'active' : '' }}">
                    <a href="{{ url('gercont/paginas') }}">
                    <i class="fa fa-globe"></i>
                      <p>Páginas</p>
                    </a>
                </li>
                <li class="{{ (Session::has('url') and Session::get('url') == 'menus') ? 'active' : '' }}">
                    <a href="{{ url('gercont/menus') }}">
                    <i class="fa fa-list-ul"></i>
                      <p>Menus</p>
                    </a>
                </li>
                <li class="{{ (Session::has('url') and Session::get('url') == 'noticias') ? 'active' : '' }}">
                    <a href="{{ url('gercont/noticias') }}">
                    <i class="fa fa-newspaper-o"></i>
                    <p>Notícias</p>
                    </a>
                </li>    
                <li class="{{ (Session::has('url') and Session::get('url') == 'videos') ? 'active' : '' }}">
                    <a href="{{ url('gercont/videos') }}">
                    <i class="fa fa-video-camera"></i>
                    <p>Vídeos</p>
                    </a>
                </li>                        
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                      <i class="nc-icon nc-button-power"></i>
                      <p>Sair</p>
                    </a>
                </li>
              </ul>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </div>
        </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand upper" href="{{ url('gercont') }}">SEAGRO > Gerenciador de Conteúdo</a>            
          </div>

          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" target="blank" href="http://www.seagro-sc.org.br/">
                  <i class="fa fa-globe text-info"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                  <i class="fa fa-sign-out text-danger"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">   
        <div class="row">    
          @yield('content')     
        </div>     
      </div>

      <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">
            
            <div class="credits ml-auto">
              <span class="copyright">
                © 2021 - 
                <script>
                  document.write(new Date().getFullYear())
                </script> - Studio Clipagem
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  
  <!--   Core JS Files   -->
  <script src="{{ asset('js/core/jquery.min.js') }}"></script>
  <script src="{{ asset('js/core/popper.min.js') }}"></script>
  <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('js/core/moment.min.js') }}"></script>
  <script src="{{ asset('js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
 
  <!-- Chart JS -->
  <script src="{{ asset('js/plugins/chartjs.min.js') }}"></script>
  <!--  Notifications Plugin    -->
  <script src="{{ asset('js/plugins/bootstrap-notify.js') }}"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
 
  <script src="{{ asset('js/paper-dashboard.min.js?v=2.0.1') }}" type="text/javascript"></script>
  <script src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('js/plugins/bootstrap-datetimepicker.js') }}"></script>
  <script src="{{ asset('js/plugins/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('demo/demo.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <script src="{{ asset('js/sweetalert2.js') }}"></script>
  <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
  @yield('script')
  <script>
    function setFormValidation(id) {
      $(id).validate({
        highlight: function(element) {
          $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
          $(element).closest('.form-check').removeClass('has-success').addClass('has-danger');
        },
        success: function(element) {
          $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
          $(element).closest('.form-check').removeClass('has-danger').addClass('has-success');
        },
        errorPlacement: function(error, element) {
          $(element).closest('.form-group').append(error);
        },
      });
    }

    $(document).ready(function() {
      // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
      //demo.initChartsPages();
      demo.initDateTimePicker();
      setFormValidation('#RegisterValidation');
    });
  </script>
  <script>
    $(document).ready(function() {

      var host =  $('meta[name="base-url"]').attr('content');
      $('.data').mask('00/00/0000',{ "placeholder": "dd/mm/YYYY" });

      /*
      const eventSource = new EventSource(host+'/certificado/status');

      eventSource.onmessage = function(event) {
          const data = JSON.parse(event.data);

          console.log(data);

          if (data.time) {
              document.getElementById('time').innerHTML = data.time;
          }
          const newElement = document.createElement("li");
          const eventList = document.getElementById("list");

          newElement.textContent = "message: " + event.data;
          eventList.appendChild(newElement);
      }
      */

      $('.select2').select2();

      $("#id_tipo_participacao_tip").change(function(){
        let valor = $('#id_tipo_participacao_tip option:selected').val(); 
        let texto = $('#id_tipo_participacao_tip option:selected').text(); 
        if(valor != 0)
          $("#tipo_participacao").html(texto);
      });

      $("#total_horas_cer").keyup(function(){
        let valor = $(this).val();

        if(valor != ''){
          if(valor > 0)
            $(".carga_horaria").css('display','block');
          else
            $(".carga_horaria").css('display','none');
          $("#carga_horaria").html(valor);
        }else{
          $(".carga_horaria").css('display','none');
        }
    
      });

      $("#ds_conteudo_cer").keyup(function(){
        let texto = $(this).val();

        if(texto != '')
          $("#conteudo").html(texto);
      });

      $("#complemento_cer").keyup(function(){
        let texto = $(this).val();

        if(texto != '')
          $("#complemento").html(texto);
      });

      $('#arquivo').on('change',function(){
        var fileName = $(this).val();
        $(this).next('.custom-file-label').html(fileName);
      });
      
      $('#datatable').DataTable({
        "pagingType": "full_numbers",
        "ordering": false,
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "Todos"]
        ],
        responsive: true,
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Buscar",
        }

      });


  
    });
  </script>
  
</body>

</html>