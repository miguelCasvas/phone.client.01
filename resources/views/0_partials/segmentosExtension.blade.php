{{--
    FORMULARIO DE CATALOGO - UBICACION DE CATALOGO - VALOR EXTENSION UBICACION CATALOGO
    PARA LA SELECCIÓN DE LA EXTENSIÓN POR UN USUARIO
--}}
<div class="row">
    @for($i = 0; $i < count($catalogo); $i++)
        <div class="col-lg-4">
            {!! Form::bsSelect('', 'catalogo[]', $options, null, ['data-select-ubic' => 'selectUbic_'.$i, 'class' => 'form-control selectCat'], false) !!}
        </div>

        <div class="col-lg-4">
            {!! Form::bsSelect('', 'ubicCatalogo[]', [null => 'selección'], null, ['id' => 'selectUbic_'.$i, 'data-segment-ext' => 'segmentExt'.$i, 'class' => 'form-control selectUbicCat'], false) !!}
        </div>

        <div class="col-lg-4">
            {!! Form::bsText('', 'numExt[]', null, ['placeholder' => 'segmento extensión', 'readonly', 'id' => 'segmentExt'.$i], false) !!}
        </div>
        <div class="hidden-lg col-xs-12 primary"><hr></div>
    @endfor
</div>