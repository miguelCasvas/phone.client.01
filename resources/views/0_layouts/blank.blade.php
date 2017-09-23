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
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="bower_components/Chart.js/Chart.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="js/demo.js"></script>

@stack('scriptsPostLoad')

</body>
</html>
