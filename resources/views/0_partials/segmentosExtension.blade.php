{{--
    FORMULARIO DE CATALOGO - UBICACION DE CATALOGO - VALOR EXTENSION UBICACION CATALOGO
    PARA LA SELECCIÓN DE LA EXTENSIÓN POR UN USUARIO
--}}
<div class="row">
    @foreach($catalogo as $pos => $item)
        <div class="col-lg-4">
            {!! Form::bsText('', '', $item->nombre_catalogo, ['data-select-ubic' => 'selectUbic_'.$pos, 'disabled', 'class' => 'form-control selectCat'], false) !!}
            <input type="hidden" name="catalogo[]" value="{{$item->id_catalogo}}">
        </div>

        <div class="col-lg-4">
            <div class="form-group ">
                <label id="ubicCatalogo[]"></label>
                <select class="form-control selectUbicCat" id="{{'selectUbic_'.$pos}}" data-segment-ext="{{'segmentExt'.$pos}}" name="ubicCatalogo[]">
                    @foreach($optUbic[$item->id_catalogo] as $key => $items)
                        <option value="{{$key}}" data-vlr-ext="{{$items['dataExt']}}">{{$items['text']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-lg-4">
            {!! Form::bsText('', 'numExt[]', null, ['placeholder' => 'segmento extensión', 'readonly', 'id' => 'segmentExt'.$pos], false) !!}
        </div>
    @endforeach
</div>