<!DOCTYPE html>



<html lang="es">
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="description" content="">
      <meta name="author" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="csrf-token" content="{{ csrf_token() }}" />

      @section('style')
          <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
          <link rel="stylesheet" href="{{ asset('public/components/jquery-ui/themes/base/jquery-ui.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/Css/bootstrap.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/components/bootstrap-select/dist/css/bootstrap-select.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/components/selectize/dist/css/selectize.bootstrap3.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/components/datatables.net-bs/css/dataTables.bootstrap.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/components/datatables.net-buttons-dt/css/buttons.dataTables.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/components/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/components/highcharts/css/highcharts.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/components/font-awesome/css/font-awesome.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/components/loaders.css/loaders.min.css') }}" media="screen">
          <link rel="stylesheet" href="{{ asset('public/Css/main.css') }}" media="screen">
      @show

      @section('script')
          <script src="{{ asset('public/components/jquery/jquery.js') }}"></script>
          <script src="{{ asset('public/components/jquery-ui/jquery-ui.js') }}"></script>
          <script src="{{ asset('public/components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
          <script src="{{ asset('public/components/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
          <script src="{{ asset('public/components/moment/moment.js') }}"></script>
          <script src="{{ asset('public/components/jszip/dist/jszip.js') }}"></script>
          <script src="{{ asset('public/components/datatables.net/js/jquery.dataTables.js') }}"></script>
          <script src="{{ asset('public/components/datatables.net-bs/js/dataTables.bootstrap.js') }}"></script>
          <script src="{{ asset('public/components/datatables.net-buttons/js/dataTables.buttons.js') }}"></script>
          <script src="{{ asset('public/components/datatables.net-buttons/js/buttons.html5.js') }}"></script>
          <script src="{{ asset('public/components/datatables.net-buttons/js/buttons.colVis.js') }}"></script>
          <script src="{{ asset('public/components/datatables.net-buttons/js/buttons.flash.js') }}"></script>
          <script src="{{ asset('public/components/datatables.net-buttons/js/buttons.print.js') }}"></script>
          <script src="{{ asset('public/components/datatables.net-responsive/js/dataTables.responsive.js') }}"></script>
          <script src="{{ asset('public/components/highcharts/js/highcharts.js') }}"></script>
          <script src="{{ asset('public/components/selectize/dist/js/standalone/selectize.js') }}"></script>
          <script src="{{ asset('public/components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
          <script src="{{ asset('public/Js/main.js') }}"></script>
      @show


      <title>{{ $titulo }}</title>
  </head>

  <body>
      @include('includes.menu')
      </br></br>
      <div class="form-container container">
          <!-- Contenedor información módulo -->
          <div class="page-header" id="banner">
            <div class="row">
              <div class="col-lg-8 col-md-7 col-sm-6">
                  <img src="{{ asset('public/Img/logo.png') }}" style="height: 184px; margin-left: -15px;">
                <p class="lead"><h4>{{ $titulo }}</h4></p>
              </div>
              <div class="col-lg-4 col-md-5 col-sm-6">
                 <div align="right">
                    <img src="{{ asset('public/Img/IDRD.png') }}?" width="250px"/>
                 </div>
              </div>
            </div>
          </div>
          <!-- FIN Contenedor información módulo -->
          <!-- Contenedor panel principal -->
          @yield('content')
          <!-- FIN Contenedor panel principal -->
      </div>
      
      <div class="ajaxloader">
        <div class="ball-scale-multiple"><div></div><div></div><div></div></div>
        <span>PROCESANDO</span>
      </div>
  </body>
</html>
