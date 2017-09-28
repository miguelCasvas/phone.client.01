<div class="radio-inline{{ $errors->has($nameCamp) ? ' has-error' : '' }}">
	<label>
	    {{ Form::radio($nameCamp, $value,false, array_merge( $attributes)) }}
		<p class="text-danger">{{ $errors->first($nameCamp, ':message')}}
	</label>
</div>