<!DOCTYPE html>
<html>
<head>
    @include('0_includes.cabeceraPP', ['tituloPagina' => 'Inicio sesión .:: PHONE UP ::.'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" />
</head>
<body class="hold-transition login-page">
    <div class="container">
        <div class="login-box">
            <div class="login-logo text-center">
                <a href="#"><img src="{{asset('img/login_phoneUp.png')}}" class="img-responsive" alt=""></a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Inicie sesión</p>

                <form action="{{route('postFormularioInicioSesion')}}" method="post">
                    <div class="form-group has-feedback">
                        <input type="email" name="correo" class="form-control" value="{{old('correo')}}" placeholder="Email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-xs-4 col-xs-offset-8">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
            <!-- /.login-box-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <nav class="navbar navbar-default navbar-fixed-bottom navbar-inverse">

        <div class="container-fluid">
            <div class="navbar-header navbar-right">

                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="#">
                    <img alt="PH::Up" src="{{asset('img/logo_phoneUp.png')}}" width="100px">
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="{{url('login')}}">Inicio</a></li>
                    <li class=""><a href="#">Quienes somos</a></li>
                    <li class=""><a href="#">Contactenos</a></li>
                    <li class=""><a href="#">Portafolio</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->

    </nav>

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
<!-- SweetAlert -->
<script src="js/sweetalert.min.js"></script>
<!-- Include this after the sweet alert js file -->
@include('sweet::alert')
</body>
</html>