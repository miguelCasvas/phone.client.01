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

	{{ Form::select($nombCamp, $value, $selected, array_merge(['class' => 'form-control'], $attributes))}}
	{!! $helpBlock !!}
</div>