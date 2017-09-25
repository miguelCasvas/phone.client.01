<!DOCTYPE html>
<html>
<head>

    @include('0_includes.cabeceraPP', ['tituloPagina' => '.:: ERROR ::.'])

</head>
<body class="hold-transition skin-blue sidebar-mini">

<div class="row">
    <br><br><br><br><br>
    <div class="col-md-4 col-md-offset-3">
        <div class="error-page box box-danger" style="padding: 8px;">
            <h2 class="headline text-red">500</h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-red"></i> Oops! Algo salio mal.</h3>

                <p>
                    Estamos trabajando para solucionarlo.
                    Mientras tanto, puede
                    @if(\Auth::check())
                        <br><a href="{{ url('inicioUsuario') }}" class="text-muted"><i class="fa fa-home" aria-hidden="true"></i>    Volver al inicio</a>
                    @else
                        <br><a href="{{ url('/') }}" class="text-muted"><i class="fa fa-home" aria-hidden="true"></i> Volver al inicio</a>
                    @endif
                    <br><a href="{{ session('_previous.url') }}" class="text-muted"><i class="fa fa-undo" aria-hidden="true"></i> Volver a la ultima página</a>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll -->
<script src="/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="/bower_components/Chart.js/Chart.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/js/demo.js"></script>

@stack('scriptsPostLoad')

</body>
</html>
