{{ Form::label (@transPAR($nameLabel, $transArgs), null, ['class' => 'control-label'])}}
<div class="input-group{{ $errors->has($nameCamp) ? ' has-error' : '' }}">
    {{ Form::number($nameCamp, $value, array_merge(['class' => 'form-control', 'step' => 'any'], $attributes))}}
    <span class="input-group-addon">
    	<i class="fa {{$iconVal}}" aria-hidden="true"></i>
    </span>
    <p class="text-danger">{{ $errors->first($nameCamp, ':message')}}</p>
</div>