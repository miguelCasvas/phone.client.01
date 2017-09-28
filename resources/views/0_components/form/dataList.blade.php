<div class="form-group{{ $errors->has($nameCamp) ? ' has-error' : '' }}">
    {{ Form::label(@transPAR($nameLabel), null, ['class' => 'control-label']) }}
    {{ Form::text('1_'.$nameCamp, $value, array_merge(['class' => 'form-control dataList', 'id' =>'1_'.$nameCamp])) }}
    {{ Form::hidden($nameCamp,$value, ['id'=>$nameCamp])}}
    <p class="text-danger">{{ $errors->first($nameCamp, ':message')}}</p>
</div>