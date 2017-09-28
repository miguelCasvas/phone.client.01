<div class="form-group {{ $errors->has($nameCamp) ? ' has-error' : '' }}">
    {{ Form::label(@transPAR($name, $transArgs), null, ['class' => 'control-label'])}}
    {{ Form::textarea($nameCamp,$value, $attributes)}}
    <p class="text-danger">{{ $errors->first($nameCamp, ':message')}}</p>
</div>