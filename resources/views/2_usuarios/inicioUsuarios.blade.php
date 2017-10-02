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

        <section class="col-lg-12 connectedSortable ui-sortable">
            <div class="nav-tabs-custom" style="cursor: move;">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="active"><a href="#crearUsuario" data-toggle="tab"><i class="fa fa-user-plus" aria-hidden="true"></i> Crear</a></li>
                    <li class=""><a href="#listadoUsuarios" data-toggle="tab"><i class="fa fa-list" aria-hidden="true"></i> Listado</a></li>
                    <li class="pull-left header"><i class="fa fa-user-o" aria-hidden="true"></i></li>
                </ul>
                <div class="tab-content no-padding">

                    <div class="chart tab-pane box" id="listadoUsuarios" >
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
                                        <th>Editar</th>
                                        <th>Eliminar</th>
                                    </tr>
                                    @php $contador = 0 @endphp
                                    @foreach($usuarios->data as $usuario)
                                        @if($usuario->id_usuario != \Auth::user()->id_usuario)
                                            <tr>
                                                <td>{{$contador++}}</td>
                                                <td>{{$usuario->identificacion}}</td>
                                                <td>{{$usuario->nombres}}</td>
                                                <td>{{$usuario->apellidos}}</td>
                                                <td>{{$usuario->email}}</td>
                                                <td style="padding-left: 20px;"><a href="{{route('getUsuario', [$usuario->id_usuario])}}"><i class="fa fa-circle-o text-aqua" aria-hidden="true"></i></a></td>
                                                <td style="padding-left: 20px;"><a href="{{route('getUsuario', [$usuario->id_usuario])}}"><i class="fa fa-circle-o text-red" aria-hidden="true"></i></a></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                    </div>
                    <!--/.chart (LISTADO USUARIOS) -->
                    <div class="chart tab-pane box active" id="crearUsuario">
                        <div class="box-header">
                            <h3 class="box-title">Formulario de Creación</h3>
                        </div>

                        <div class="box-body">
                            {{-- FORMULARIO --}}
                            @component ('0_partials.formularioUsuario')
                                @slot('rutaFormulario', route('postUsuario'))
                                @slot('datosUsuario', $datosUsuario)
                                @slot('btnFormulario')
                                    <button type="submit" class="btn btn-success pull-right">Confirmar Creación</button>
                                @endslot
                            @endcomponent

                        </div>
                    </div>
                    <!--./chart (CREACION DE USUARIO) -->
                </div>
            </div>
        </section>


        <div class="col-xs-12">

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