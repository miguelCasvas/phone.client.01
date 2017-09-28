{{ Form::label(@transPAR($nameLabel), null, ['class' => 'control-label']) }}
<div class="input-group">
    {{ Form::text($nameCamp, $value, array_merge(['class' => 'form-control'], $attributes)) }}
    <span class="input-group-addon">
    	<i class="fa {{$iconVal}}" aria-hidden="true"></i>
    </span>
    <p class="text-danger">{{ $errors->first($nameCamp, ':message')}}</p>
</div>

<!--<div class="input-group">
    <input type="text" class="form-control" placeholder="Search for...">
    <span class="input-group-btn">
        <button class="btn btn-secondary" type="button">Go!</button>
    </span>
</div>-->