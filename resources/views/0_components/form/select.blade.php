<div class="form-group{{ $errors->has($nameCamp) ? ' has-error' : '' }}">
    {{ Form::label(@transPAR($nameLabel, $transArgs), null, ['class' => 'control-label']) }}
	{{ Form::select($nameCamp, $value, $selected, array_merge(['class' => 'form-control'], $attributes))}}
	<p class="text-danger">{{ $errors->first($nameCamp, ':message')}}</p>
</div>