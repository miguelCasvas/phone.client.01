{{-- ITEM DE MARCADO CARGADO DESDE JAVASCRIPT --}}
@if(isset($scriptMarcado))
<li class="list-group-item" style="cursor: n-resize;">{{$textoMarcado}} \
    <div class="btn-group pull-right" role="group" aria-label="..."> \
        <button type="button" class="btn btn-default btn-xs editarMarcado" \
                data-comentario="%comentario%" \
                data-metodo="%metodo%" \
                data-metodo-params="%metodoParams%" \
        >Editar</button> \
        <button type="button" class="btn btn-default btn-xs eliminaMarcado">Borrar</button> \
    </div> \
</li> \
@elseif(isset($scriptEditarMarcado))
<br><br> \
<form action="{{route('postMarcado')}}" method="post" class="formMarcador"> \
    {{csrf_field()}} \
    <div class="row"> \
        <div class="col-md-4"> \
            <div class="form-group"> \
            <input id="segundosMarcado" class="form-control" placeholder="segundo para redirigir llamada" type="text" name="segundosMarcado"> \
            </div> \
        </div> \
        <div class="col-md-8"> \
            <div class="input-group"> \
                <input id="new-event" class="form-control" placeholder="%comentarioMarcado%" type="text" name="nuevoMarcado"> \
                <div class="input-group-btn"> \
                    <button id="add-new-event" type="submit" class="btn btn-primary btn-flat">Confirmar</button> \
                </div> \
            </div> \
        </div> \
        <input type="hidden" name="metodo" value="%metodo%"> \
        <input type="hidden" name="metodoParams" value="%metodoParams%"> \
        <input type="hidden" name="extension" value="" class="inputExtension"> \
    </div> \
</form> \
@endif