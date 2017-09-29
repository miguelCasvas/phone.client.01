@php
    # has-success | has-warning | has-error
    $classGroup = '';
    $iconLabel = '<i class="fa fa-asterisk" aria-hidden="true"></i>';
    $helpBlock = '';

    # Validar si existen errores para visualizar
    if ($errors->has($nombCamp)){
        $classGroup = 'has-error';
        $iconLabel = '<i class="fa fa-times-circle-o"></i>';
        $helpBlock = '<span class="help-block">'. $errors->first($nombCamp, ':message') .'</span>';
    }

@endphp
<div class="form-group {{$classGroup}}">
    <label id="{{$nombCamp}}">
        @if($obligatorio) <small>{!! $iconLabel !!}</small> @endif {{$titulo}}
    </label>

    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa {{$icon or 'fa-bug'}}"></i>
        </div>
        {{ Form::text($nombCamp, $value, array_merge(['class' => 'form-control'], $attributes)) }}
    </div>
    {!! $helpBlock !!}
</div>

{{-- EJEMPLO DE USO DEL COMPONENTE --}}
{{-- Fecha nacimiento --}}
{{--
{{ Form::bsTextIcon(
    'Fecha de nacimiento',
    'fechaNacimiento',
    $datosUsuario->fecha_nacimiento,
    ['data-inputmask' => '\'alias\': \'yyyy-mm-dd\'', 'data-mask' => ''],
    'fa-calendar', true) }}
--}}
