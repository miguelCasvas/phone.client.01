<div class="form-group {{ $errors->has($nameCamp) ? ' has-error' : '' }}">
    {{ Form::label(@transPAR($nameLabel, $transArgs), null, ['class' => 'control-label'])}}
    {{ Form::file($nameCamp, $attributes)}}
    <p class="text-danger">{{ $errors->first($nameCamp, ':message')}}</p>
</div>