@component('0_layouts.blank')

    @slot('menuPagina')
        <h1>PERFIL <small>{{$datosUsuario->nombres}}</small></h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Mi Perfil</li>
        </ol>
    @endslot

    @section('contenidoPagina')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-tag" aria-hidden="true"></i> <h3 class="box-title">Información general</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('postMiPerfil', [$datosUsuario->id_usuario])}}"  method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="box-body row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label id="identificacion"><small><i class="fa fa-asterisk" aria-hidden="true"></i></small> Identificación</label>
                                <input class="form-control" name="identificacion" id="identificacion" placeholder="Nombres" type="text" value="{{$datosUsuario->identificacion}}">
                            </div>
                            <div class="form-group">
                                <label for="nombres"><small><i class="fa fa-asterisk" aria-hidden="true"></i></small> Nombres</label>
                                <input class="form-control" name="nombres" id="nombres" placeholder="Nombres" type="text" value="{{$datosUsuario->nombres}}">
                            </div>
                            <div class="form-group">
                                <label for="apellidos"><small><i class="fa fa-asterisk" aria-hidden="true"></i></small> Apellidos</label>
                                <input class="form-control" name="apellidos" id="apellidos" placeholder="Nombres" type="text" value="{{$datosUsuario->apellidos}}">
                            </div>
                            <div class="form-group">
                                <label id="fechaNacimiento"><small><i class="fa fa-asterisk" aria-hidden="true"></i></small> Fecha de nacimiento</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input class="form-control" name="fechaNacimiento" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask="" type="text" value="{{$datosUsuario->fecha_nacimiento}}">
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label id="idConjunto">Conjunto Residencial</label>
                                <input class="form-control" id="idConjunto" type="text" value="{{$datosUsuario->nombre_conjunto}}" disabled="disabled">
                                <input class="form-control" name="idConjunto" type="hidden" value="{{$datosUsuario->id_conjunto}}">
                            </div>
                            <div class="form-group">
                                <label><small><i class="fa fa-asterisk" aria-hidden="true"></i></small> Dirección Conjunto</label>
                                <input class="form-control" name="direccion" id="direccion" type="text" value="{{$datosUsuario->direccion}}" disabled="disabled">
                                <input class="form-control" type="hidden" value="{{$datosUsuario->direccion}}">
                            </div>
                            <div class="form-group">
                                <label><small><i class="fa fa-asterisk" aria-hidden="true"></i></small> Teléfono Conjunto</label>
                                <input class="form-control" id="telefono" placeholder="Telefono" type="text" value="{{$datosUsuario->telefono}}" disabled="disabled">
                                <input name="telefono" type="hidden" value="{{$datosUsuario->telefono}}">
                            </div>
                        </div>
                    </div>
                    <div class="box-header with-border">
                        <i class="fa fa-tag" aria-hidden="true"></i> <h3 class="box-title">Usuario</h3>
                    </div>
                    <div class="box-body row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label id="correo"><small><i class="fa fa-asterisk" aria-hidden="true"></i></small> Correo</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope-o"  aria-hidden="true"></i>
                                    </div>
                                    <input readonly class="form-control" name="correo" id="correo" type="text" value="{{$datosUsuario->email}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="correo">Rol</label>
                                <input class="form-control" name="correo" id="correo" type="text" value="{{$datosUsuario->nombre_rol}}" disabled="disabled">
                                <input name="idRol" type="hidden" value="{{$datosUsuario->id_rol}}">
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label><small><i class="fa fa-asterisk" aria-hidden="true"></i></small> Contraseña</label>
                                <input class="form-control" name="contrasenia" type="password" value="" placeholder="*******">
                            </div>
                            <div class="form-group">
                                <label><small><i class="fa fa-asterisk" aria-hidden="true"></i></small> Confirmación de contraseña</label>
                                <input class="form-control" name="contrasenia_confirmation" type="password" value="" placeholder="*******">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <span class="text-muted"><small>(<i class="fa fa-asterisk" aria-hidden="true"></i>) Campo obligatorio!</small></span>
                        <button type="submit" class="btn btn-info pull-right">Actualizar</button>
                    </div>
                </form>
            </div>
            </div>

            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Permisos</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Permiso</th>
                                    <th>Modulo</th>
                                    <th style="width: 10px">#</th>
                                </tr>
                                @php
                                    $contador = 0;
                                @endphp
                                @foreach($datosUsuario->permisos as $permiso)
                                    <tr>
                                        <td>{{$permiso->nombre_permiso}}</td>
                                        <td>{{$permiso->nombre_modelo}}</td>
                                        <td class="text-success"><i class="fa fa-check-circle-o" aria-hidden="true"></i></td>
                                    </tr>
                                    @php
                                        $contador++;
                                        //if ($contador == 10) break;
                                    @endphp
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            <li><a href="#">«</a></li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">»</a></li>
                        </ul>
                    </div>
                </div>
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