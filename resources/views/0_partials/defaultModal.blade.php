{{--$classWidth = [ modal-lg | modal-sm ]--}}

<div class="modal fade {{$classWidth or ''}}" id="{{ $idModalDef or 'modal-default' . rand(1,100) }}" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ $titleModalDef or '.:: ::.' }}</h4>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" id="{{$idBtnClose or ''}}">
                    {{$textBtnCancel or 'Cancelar'}}</button>

                    <input type="{{$typeButton or 'button'}}" class="btn btn-primary" id="{{$idBtnSave or ''}}" value="{{$textBtnSave or 'Confirmar'}}">
                    </input>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
