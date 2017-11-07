{{--
    FORMULARIO DE CATALOGO - UBICACION DE CATALOGO - VALOR EXTENSION UBICACION CATALOGO
    PARA LA SELECCIÓN DE LA EXTENSIÓN POR UN USUARIO
--}}
<div class="row">
    @foreach($catalogo as $pos => $item)
        <div class="col-lg-4">
            {!! Form::bsText('', '', $item->nombre_catalogo, ['data-select-ubic' => 'selectUbic_'.$pos, 'disabled', 'id' => 'segmentExt'.$pos, 'class' => 'form-control selectCat'], false) !!}
            <input type="hidden" name="catalogo[]" value="{{$item->id_catalogo}}">
        </div>

        <div class="col-lg-4">
            {!! Form::bsSelect('', 'ubicCatalogo[]', $optUbic[$item->id_catalogo], null, ['id' => 'selectUbic_'.$pos, 'data-segment-ext' => 'segmentExt'.$pos, 'class' => 'form-control selectUbicCat'], false) !!}
        </div>

        <div class="col-lg-4">
            {!! Form::bsText('', 'numExt[]', null, ['placeholder' => 'segmento extensión', 'readonly', 'id' => 'segmentExt'.$pos], false) !!}
        </div>
    @endforeach
</div>