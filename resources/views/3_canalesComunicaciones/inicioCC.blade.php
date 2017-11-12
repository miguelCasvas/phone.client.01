@component('0_layouts.blank')
    @slot('activeCC', 'active')
    @slot('activeInicio', 'active')

    @slot('menuPagina')
        <h1>
            {{trans('cc.titulo')}}
            <small>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i> {{trans('generales.inicio')}}</a></li>
            <li class="active">{{trans('cc.canalescomunicacion')}}</li>
        </ol>
    @endslot

    @section('contenidoPagina')
        <div class="box">
            <div class="box-header with-border">
                <h3></h3>
                <div class="box-tools">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom"  title="{{trans('cc.eliminarcanales')}}" id="btnEliminarCanales"><i class="fa fa-trash-o"></i></button>
                        <button type="button" class="btn btn-default btn-sm" title="{{trans('cc.agregarcanal')}}" id="btnCrearCanal"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form action="#" name="formCC" method="post">
                    {{ csrf_field() }}
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="info">
                                <th>{{trans('cc.conjunto')}}</th>
                                <th>{{trans('cc.indicativo')}}</th>
                                <th style="width: 250px">{{trans('cc.canal')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($arregloCanales as $elemento)
                        <tr><td rowspan="{{count($elemento['canales']) + 1}}"><strong><u>{{$elemento['conjunto']}}</u></strong></td></tr>
                        @foreach($elemento['canales'] as $_elemento)
                        <tr class="info">
                            <td style="width: 18px">{{$_elemento['indicativo']}}</td>
                            <td>
                                <small><i class="fa  fa-check"></i></small> {{$_elemento['canal']}}
                                <input type="checkbox" name="cc_conjunto[{{$_elemento['id_conjunto']}}][{{$_elemento['id_canal']}}]" value="eliminar" style="display: none">
                                <div class="btn-group btn-group-xs pull-right">
                                    <button type="button" class="btn btn-default check-eliminarCC" data-toggle="tooltip" data-placement="top" title="{{trans('cc.seleccioneeliminar')}}"><i class="fa fa-square-o" aria-hidden="true"></i></button>
                                    <button
                                            type="button"
                                            class="btn btn-default btn-editarCC"
                                            data-conjunto="{{$_elemento['id_conjunto']}}"
                                            data-idCc="{{$_elemento['id_canal']}}"
                                            data-cc="{{$_elemento['canal']}}"
                                            data-indi="{{$_elemento['indicativo']}}"
                                    ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">

            </div>
        </div>

        @component('0_partials.defaultModal', ['idModalDef' => 'modalCrearCanal', 'titleModalDef' => trans('cc.crearcanal'), 'idBtnSave' => 'btnSaveCanal'])
            <form action="{{route('postCrearCC')}}" name="formCrearCC" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xs-12">{{Form::bsSelect(trans('cc.conjunto'), 'idConjunto', $conjuntos, null, [], true)}}</div>
                    <div class="col-lg-3 col-xs-12">{{Form::bsText(trans('cc.indicativo'), 'indicativo', null, [], true)}}</div>
                    <div class="col-lg-9 col-xs-12">{{Form::bsText(trans('cc.canalcomunicacion'), 'canal', null, [], true)}}</div>
                </div>
            </form>
        @endcomponent
    @endsection

    @push('stylesheets')

    @endpush

    @push('scriptsPostLoad')
        <!-- InputMask -->
        <script src="{{asset('plugins/input-mask/jquery.inputmask.js')}}"></script>
        <script src="{{asset('plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
        <script src="{{asset('plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
        <script>

            var FormularioCC = function(){

            };

            FormularioCC.prototype.eliminacionCanales = function(){
                swal({
                    title: "{{trans('cc.error.titulo')}}",
                    text: "{{trans('cc.error.texto')}}",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).
                then((willDelete) => {
                    if (willDelete) {
                        $('form[name="formCC"]').attr('action', '{{route('getEliminacionCC')}}');
                        $('form[name="formCC"]').submit();
                    }
                });
            };

            FormularioCC.prototype.crearCanal = function(){
                $('form[name="formCrearCC"]').submit();
            };

            FormularioCC.prototype.editarCanal = function(btn){
                conjunto = $(btn).data('conjunto');
                idcc = $(btn).data('idcc');
                indi = $(btn).data('indi');
                cc = $(btn).data('cc');

                $('select[name="idConjunto"] option:eq('+ conjunto +')').attr('selected', 'selected');
                $('input[name="indicativo"]').val(indi);
                $('input[name="canal"]').val(cc);

                $('form[name="formCrearCC"]').attr('action', '{{route('postEditarCC', [''])}}/' + idcc);
                $('#modalCrearCanal').modal();
            };

            FormularioCC.prototype.seleccionarCC_Eliminar= function(btn){

                elementI = $(btn).find('i.fa');
                elementCheck = $(btn).parent().prev();

                if($(elementI).hasClass('fa-square-o')){
                    $(elementI).removeClass('fa-square-o').addClass('fa-check-square-o');
                    $(elementCheck).attr('checked', true);
                }
                else{
                    $(elementI).removeClass('fa-check-square-o').addClass('fa-square-o');
                    $(elementCheck).attr('checked', false);
                }

            };

            var objFormCC = new FormularioCC();

            $(document).ready(function(){

                $('#btnEliminarCanales').click(function(){
                    objFormCC.eliminacionCanales();
                });

                $('#btnCrearCanal').click(function(){
                    $('select[name="idConjunto"] option:eq(0)').attr('selected', 'selected');
                    $('input[name="indicativo"]').val('');
                    $('input[name="canal"]').val('');
                    $('form[name="formCrearCC"]').attr('action', '{{route('postCrearCC')}}');
                    $('#modalCrearCanal').modal();
                });

                $('#btnSaveCanal').click(function(){
                    objFormCC.crearCanal();
                });

                $('.check-eliminarCC').click(function(){
                    $(this).blur();
                    objFormCC.seleccionarCC_Eliminar($(this));
                });

                $('.btn-editarCC').click(function(){
                    $(this).blur();
                    objFormCC.editarCanal($(this));
                });



                {!! $scriptModal !!}
            });

        </script>

    @endpush

@endcomponent