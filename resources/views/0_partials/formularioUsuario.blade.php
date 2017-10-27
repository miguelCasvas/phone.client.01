<!-- form usuario -->
<form role="form" action="{{$rutaFormulario}}"  method="post" name="{{$nombreForm or 'Form_' . rand(1, 100)}}">
    {{ csrf_field() }}
    {{ $metodo or ''}}
    <div class="box-header with-border">
        <i class="fa fa-tag" aria-hidden="true"></i> <h3 class="box-title">{{trans('usuario.transversales.usuario')}}</h3>
    </div>
    <div class="box-body row">
        <div class="col-xs-12 col-md-6">
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

            {{-- CONTRASEÑA --}}
            {{ Form::bsPassword(trans('usuario.transversales.contraseña'), 'contrasenia', [ 'placeholder'=> '*******'], true) }}

            {{-- CONTRASEÑA --}}
            {{ Form::bsPassword(trans('usuario.transversales.confirmacioncontraseña'), 'contrasenia_confirmation', [ 'placeholder'=> '*******'], true) }}

        </div>
    </div>
    <div class="box-header with-border">
        <i class="fa fa-tag" aria-hidden="true"></i> <h3 class="box-title">{{trans('conjunto')}}</h3>
    </div>
    <div class="box-body row">
        <div class="col-xs-12 col-md-6">
            @if($campos->conjunto->select)
                {{Form::bsSelect('Conjunto Residencial', 'idConjunto', $campos->conjunto->opc, $datosUsuario->id_conjunto, [], true)}}
            @else
                {{-- NOMBRE CONJUNTO --}}
                {{ Form::bsText('Conjunto Residencial', 'nombreConjunto', $datosUsuario->nombre_conjunto, ['disabled' => 'disabled'], false) }}
                <input type="hidden" value="{{$datosUsuario->id_conjunto}}" name="idConjunto">
            @endif
            {{-- DIRECCION CONJUNTO --}}
            {{ Form::bsText('Dirección Conjunto', 'direccion', $datosUsuario->direccion, ['disabled' => 'disabled'], false) }}

            {{-- TELEFONO CONJUNTO --}}
            {{ Form::bsText('Teléfono Conjunto', 'telefono', $datosUsuario->telefono, ['disabled' => 'disabled'], false) }}

        </div>
        <div class="col-xs-12 col-md-6">
            {{Form::bsSelect('Extensiones', 'idExtension', [], null, [], true)}}
        </div>
    </div>
    <div class="box-footer">
        <span class="text-muted"><small>(<i class="fa fa-asterisk" aria-hidden="true"></i>) {{trans('usuario.transversales.campoobligatorio')}}</small></span>
        {{$btnFormulario}}
    </div>
</form>
