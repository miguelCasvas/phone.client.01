@component('0_layouts.blank')
    @slot('activeUsuarios', 'active')

    @slot('menuPagina')
        <h1>
            USUARIOS
            <small>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Usuarios</li>
        </ol>
    @endslot

@section('contenidoPagina')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Listado</h3>

                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input name="table_search" class="form-control pull-right" placeholder="Search" type="text">

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Identificación</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                        @foreach($usuarios->data as $usuario)
                            @if($usuario->id_usuario != \Auth::user()->id_usuario)
                                <tr>
                                    <td>{{$usuario->id_usuario}}</td>
                                    <td>{{$usuario->identificacion}}</td>
                                    <td>{{$usuario->nombres}}</td>
                                    <td>{{$usuario->apellidos}}</td>
                                    <td>{{$usuario->email}}</td>
                                    <td align="center">
                                        <a href="" class="btn btn-block btn-info btn-xs"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>


@endsection

@push('stylesheets')

@endpush

@push('scriptsPostLoad')
    <!-- InputMask -->
    <script src="plugins/input-mask/jquery.inputmask.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <script>
        $(function () {

            //Money Euro
            $('[data-mask]').inputmask()
        })

    </script>
@endpush

@endcomponent