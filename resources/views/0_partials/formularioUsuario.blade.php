<!-- form usuario -->
<form role="form" action="{{$rutaFormulario}}"  method="post" name="{{$nombreForm or 'Form_' . rand(1, 100)}}">
    {{ csrf_field() }}
    {{ $metodo or ''}}
    <div class="box-body row">
        <div class="col-xs-12 col-md-6">
            {{-- IDENTIFICACION --}}
            {{ Form::bsText('Identificación', 'identificacion', $datosUsuario->identificacion, [], true) }}

            {{-- NOMBRES --}}
            {{ Form::bsText('Nombres', 'nombres', $datosUsuario->nombres, [], true) }}

            {{-- APELLIDOS --}}
            {{ Form::bsText('Apellidos', 'apellidos', $datosUsuario->apellidos, [], true) }}

            {{-- FECHA NACIMIENTO --}}
            {{ Form::bsTextIcon(
                    'Fecha de nacimiento',
                    'fechaNacimiento',
                    $datosUsuario->fecha_nacimiento,
                    ['data-inputmask' => '\'alias\': \'yyyy-mm-dd\'', 'data-mask' => ''],
                    'fa-calendar',
                    true
                )
             }}

        </div>
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
    </div>
    <div class="box-header with-border">
        <i class="fa fa-tag" aria-hidden="true"></i> <h3 class="box-title">Usuario</h3>
    </div>
    <div class="box-body row">
        <div class="col-xs-12 col-md-6">

            {{-- CORREO --}}
            {{ Form::bsTextIcon(
                    'Correo',
                    'correo',
                    $datosUsuario->email,
                    ['readonly' => $campos->correo->readOnly],
                    'fa-envelope-o',
                    false
                )
             }}

            {{-- ROL --}}
            @if($campos->rol->select)
                {{Form::bsSelect('Rol', 'idRol', $campos->rol->opc, $datosUsuario->id_rol, [], true)}}
            @else
                {{ Form::bsText('Rol', 'rol', $datosUsuario->nombre_rol, ['disabled' => 'disabled'], false) }}
                <input name="idRol" type="hidden" value="{{$datosUsuario->id_rol}}">
            @endif

        </div>
        <div class="col-xs-12 col-md-6">

            {{-- CONTRASEÑA --}}
            {{ Form::bsPassword('Contraseña', 'contrasenia', [ 'placeholder'=> '*******'], true) }}

            {{-- CONTRASEÑA --}}
            {{ Form::bsPassword('Confirmación contraseña', 'contrasenia_confirmation', [ 'placeholder'=> '*******'], true) }}

        </div>
    </div>
    <div class="box-footer">
        <span class="text-muted"><small>(<i class="fa fa-asterisk" aria-hidden="true"></i>) Campo obligatorio!</small></span>
        {{$btnFormulario}}
    </div>
</form>
