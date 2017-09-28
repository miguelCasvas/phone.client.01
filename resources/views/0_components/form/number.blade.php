<div class="form-group{{ $errors->has($nameCamp) ? ' has-error' : '' }}">
    {{ Form::label (@transPAR($nameLabel, $transArgs), null, ['class' => 'control-label'])}}
    {{ Form::number($nameCamp, $value, array_merge(['class' => 'form-control', 'step' => 'any'], $attributes))}}
    <p class="text-danger">{{ $errors->first($nameCamp, ':message')}}</p>
</div>