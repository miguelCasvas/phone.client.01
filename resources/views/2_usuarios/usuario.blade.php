@component('0_layouts.blank')

    @slot('menuPagina')
        <h1>
            PERFIL <small>{{$datosUsuario->nombres}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="{{route('getListadoUsuarios')}}"><i class="fa fa-dashboard"></i> usuarios</a></li>
            <li class="active">Perfil usuario</li>
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
                <form role="form" action="{{route('putUsario', [$datosUsuario->id_usuario])}}"  method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="box-body row">
                        <div class="col-xs-12 col-md-6">
                            {{-- identificacion --}}
                            {{ Form::bsText('Identificacion','identificacion', $datosUsuario->identificacion, [], true) }}

                            {{-- nombres --}}
                            {{ Form::bsText('Nombres','nombres', $datosUsuario->nombres, [], true) }}

                            {{-- apellidos --}}
                            {{ Form::bsText('Apellidos','apellidos', $datosUsuario->nombres, [], true) }}

                            {{-- Fecha nacimiento --}}
                            {{ Form::bsTextIcon(
                                'Fecha de nacimiento',
                                'fechaNacimiento',
                                $datosUsuario->fecha_nacimiento,
                                ['data-inputmask' => '\'alias\': \'yyyy-mm-dd\'', 'data-mask' => ''],
                                'fa-calendar', true) }}

                        </div>
                        <div class="col-xs-12 col-md-6">

                            {{-- conjunto residencial --}}
                            {{ Form::bsText('Conjunto Residencial','idConjunto', $datosUsuario->nombre_conjunto, ['disabled'=> 'disabled'], false) }}
                            <input class="form-control" name="idConjunto" type="hidden" value="{{$datosUsuario->id_conjunto}}">

                            {{-- Dirección conjunto --}}
                            {{ Form::bsText('Dirección conjunto','direccion', $datosUsuario->direccion, ['disabled'=> 'disabled'], false) }}
                            <input class="form-control" type="hidden" value="{{$datosUsuario->direccion}}">

                            {{-- Telefono conjunto --}}
                            {{ Form::bsText('Teléfono conjunto','direccion', $datosUsuario->telefono, ['disabled'=> 'disabled'], false) }}
                            <input class="form-control" type="hidden" value="{{$datosUsuario->telefono}}">

                        </div>
                    </div>
                    <div class="box-header with-border">
                        <i class="fa fa-tag" aria-hidden="true"></i> <h3 class="box-title">Usuario</h3>
                    </div>
                    <div class="box-body row">
                        <div class="col-xs-12 col-md-6">

                            {{-- Correo --}}
                            {{ Form::bsTextIcon(
                                'Correo',
                                'correo',
                                $datosUsuario->email,
                                [],
                                'fa-envelope-o', true) }}

                            {{ Form::bsText('Rol', 'nombreRol', $datosUsuario->nombre_rol, ['disabled' => 'disabled'], false) }}
                            <input name="idRol" type="hidden" value="{{$datosUsuario->id_rol}}">
                        </div>
                        <div class="col-xs-12 col-md-6">

                            {{-- contraseña --}}
                            {{ Form::bsPassword('Contraseña', 'contrasenia', null, ['placeholder' => '*******'], true) }}

                            {{-- contraseña --}}
                            {{ Form::bsPassword('Confirmación contraseña', 'contrasenia_confirmation', null, ['placeholder' => '*******'], true) }}

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
    <script src="/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <script>
        $(function () {

            //Money Euro
            $('[data-mask]').inputmask()
        })
    </script>
@endpush
@endcomponent