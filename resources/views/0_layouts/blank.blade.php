<!DOCTYPE html>
<html>
<head>

    @include('0_includes.cabeceraPP')

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">

        <!-- Logo -->
        <a href="index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>P</b> UP</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>PHONE</b> UP</span>
        </a>

        {{-- MENU SUPERIOR --}}
        @include('0_includes.menuSuperior')

    </header>

    {{-- MENU LATERAL IZQ. --}}
    @include('0_includes.menuLateral_Izq')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            {!! $menuPagina !!}
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('contenidoPagina')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    {{-- PIE DE PAGINA --}}
    @include('0_includes.pieDePagina')

    {{-- MENU LATERAL DER. CONFIGURACIONES --}}
    @include('0_includes.menuLateral_Der_Config')

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('js/adminlte.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap  -->
<script src="{{asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- SlimScroll -->
<script src="{{asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('bower_components/Chart.js/Chart.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('js/demo.js')}}"></script>
<!-- SweetAlert -->
<script src="{{asset('js/sweetalert.min.js')}}"></script>
<!-- Include this after the sweet alert js file -->
@include('sweet::alert')

@stack('scriptsPostLoad')

</body>
</html>
