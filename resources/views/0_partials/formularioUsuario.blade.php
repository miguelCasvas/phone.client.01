<!-- form usuario -->
<form role="form" action="{{$rutaFormulario}}"  method="post" name="{{$nombreForm or 'Form_' . rand(1, 100)}}">
    {{ csrf_field() }}
    {{ $metodo or ''}}
    <div class="box-header with-border">
        <i class="fa fa-tag" aria-hidden="true"></i> <h3 class="box-title">{{trans('usuario.transversales.usuario')}}</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <div class="btn-group">
                <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                    <i class="fa fa-wrench"></i></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#" data-toggle="modal" data-target="#ModalPW">{{trans('usuario.transversales.cambioPw')}}</a></li>
                    <li class="divider"></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="box-body row">
            <div class="col-xs-12 col-lg-6">
                {{-- IDENTIFICACION --}}
                {{ Form::bsText(trans('usuario.transversales.identificacion'), 'identificacion', $datosUsuario->identificacion, [], true) }}

                {{-- NOMBRES --}}
                {{ Form::bsText(trans('usuario.transversales.nombres'), 'nombres', $datosUsuario->nombres, [], true) }}

                {{-- APELLIDOS --}}
                {{ Form::bsText(trans('usuario.transversales.apellidos'), 'apellidos', $datosUsuario->apellidos, [], true) }}

                {{-- FECHA NACIMIENTO --}}
                {{ Form::bsTextIcon(
                        trans('usuario.transversales.fechaNacimiento'),
                        'fechaNacimiento',
                        $datosUsuario->fecha_nacimiento,
                        ['data-inputmask' => '\'alias\': \'yyyy-mm-dd\'', 'data-mask' => ''],
                        'fa-calendar',
                        true
                    )
                 }}

            </div>
            <div class="col-xs-12 col-md-6">

                {{-- ROL --}}
                @if($campos->rol->select)
                    {{Form::bsSelect(trans('usuario.transversales.rol'), 'idRol', $campos->rol->opc, $datosUsuario->id_rol, [], true)}}
                @else
                    {{ Form::bsText('Rol', 'rol', $datosUsuario->nombre_rol, ['disabled' => 'disabled'], false) }}
                    <input name="idRol" type="hidden" value="{{$datosUsuario->id_rol}}">
                @endif

                {{-- CORREO --}}
                {{ Form::bsTextIcon(
                        trans('usuario.transversales.correo'),
                        'correo',
                        $datosUsuario->email,
                        ['readonly' => $campos->correo->readOnly],
                        'fa-envelope-o',
                        false
                    )
                 }}

            </div>
    </div>
    <div class="box-header with-border">
        <i class="fa fa-tag" aria-hidden="true"></i> <h3 class="box-title">{{trans('conjunto')}}</h3>
    </div>
    <div class="box-body row">
        <div class="col-xs-12 col-md-6">
            {{Form::bsSelect('Conjunto Residencial', 'idConjunto', $campos->conjunto->opc, $datosUsuario->id_conjunto, [], true)}}
        </div>
        <div class="col-xs-12 col-md-6">
            {{-- DIRECCION CONJUNTO --}}
            {{ Form::bsText('Dirección Conjunto', 'direccion', $datosUsuario->direccion, ['disabled' => 'disabled'], false) }}

            {{-- TELEFONO CONJUNTO --}}
            {{ Form::bsText('Teléfono Conjunto', 'telefono', $datosUsuario->telefono, ['disabled' => 'disabled'], false) }}
        </div>
    </div>
    <div class="box-footer">
        <span class="text-muted"><small>(<i class="fa fa-asterisk" aria-hidden="true"></i>) {{trans('usuario.transversales.campoobligatorio')}}</small></span>
        {{$btnFormulario}}
    </div>
</form>
