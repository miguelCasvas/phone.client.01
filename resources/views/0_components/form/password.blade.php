@php
    $classGroup = null; # has-success | has-warning | has-error
    $iconLabel = null;
    $helpBlock = null;

    # Validar si el campo es obligatorio
    if ($obligatorio){
        $iconLabel = '<i class="fa fa-asterisk" aria-hidden="true"></i>';
    }

    # Validar si existen errores para visualizar
    if ($errors->has($nombCamp)){
        $classGroup = 'has-error';
        $iconLabel = '<i class="fa fa-times-circle-o"></i>';
        $helpBlock = $errors->first($nombCamp, ':message');
    }

@endphp
<div class="form-group {{$classGroup}}">
    <label id="{{$nombCamp}}"><small>{!! $iconLabel !!} </small>{{$titulo}}</label>
    {{ Form::password($nombCamp, array_merge(['class' => 'form-control'], $attributes)) }}
    <span class="help-block">{!! $helpBlock !!}</span>
</div>