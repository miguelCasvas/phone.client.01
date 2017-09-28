<div class="radio-inline{{ $errors->has($nameCamp) ? ' has-error' : '' }}">
	<label>
	    {{Form::checkbox($nameCamp, $value, true,array_merge($attributes))}} {{transPAR($nameLabel)}}
    	<p class="text-danger">{{ $errors->first($nameCamp, ':message')}}</p>
	</label>
</div>

