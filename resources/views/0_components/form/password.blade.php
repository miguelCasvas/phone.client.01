<div class="form-group{{ $errors->has($nameCamp) ? ' has-error' : '' }}">
    @php
        if(!empty($nameLabel)){
    @endphp
    {{ Form::label(@transPAR($nameLabel), null, ['class' => 'control-label']) }}
    @php
        }
    @endphp

    {{ Form::password($nameCamp, array_merge(['class' => 'form-control'], $attributes))}}
    <p class="text-danger">{{ $errors->first($nameCamp, ':message')}}</p>
</div>