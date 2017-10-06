@component('0_layouts.blank')
    @slot('activeCatalogo', 'active')

    @slot('menuPagina')
        <h1>
            CATALOGO DE CONJUNTOS
            <small>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Catalogos</li>
        </ol>
    @endslot

    @section('contenidoPagina')
        <div class="box">
            <div class="box-header with-border">
                <h3></h3>
                <div class="box-tools">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom"  title="Eliminar Canales marcados" id="btnEliminarCanales"><i class="fa fa-trash-o"></i></button>
                        <button type="button" class="btn btn-default btn-sm" title="Agregar Canal" id="btnCrearCatalogo"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                <form action="#" name="formCC" method="post">
                    {{ csrf_field() }}
                    <div class="col-lg-8 col-xs-12 table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr class="info">
                                <th>Conjunto</th>
                                <th>Catalogo</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($arregloCatalogos as $elemento)
                                <tr><td rowspan="{{count($elemento['catalogo']) + 1}}" style="width: 250px"><strong><u>{{$elemento['conjunto']}}</u></strong></td></tr>
                                @foreach($elemento['catalogo'] as $_elemento)
                                    <tr class="info">
                                        <td>
                                            <small><i class="fa  fa-check"></i></small> {{$_elemento['nombre_catalogo']}}
                                            <input type="checkbox" name="catalogo_conjunto[{{$_elemento['id_conjunto']}}][{{$_elemento['id_catalogo']}}]" value="eliminar" style="display: none">
                                            <div class="btn-group btn-group-xs pull-right">
                                                <button type="button" class="btn btn-default check-eliminarCatalogo" data-toggle="tooltip" data-placement="top" title="Seleccione para eliminar"><i class="fa fa-square-o" aria-hidden="true"></i></button>
                                                <button
                                                        type="button"
                                                        class="btn btn-default btn-editarCatalogo"
                                                        data-conjunto = "{{$_elemento['id_conjunto']}}"
                                                        data-idCatalogo = "{{$_elemento['id_catalogo']}}"
                                                        data-catalogo = "{{$_elemento['nombre_catalogo']}}"
                                                ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">

            </div>
        </div>

        @component('0_partials.defaultModal', ['idModalDef' => 'modalCatalogo', 'titleModalDef' => '.:: Crear Catalogo ::.', 'idBtnSave' => 'btnSaveCanal'])
            <form action="{{route('postCrearCC')}}" name="formCrearCC" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xs-12">{{Form::bsSelect('Conjunto', 'idConjunto', $conjuntos, null, [], true)}}</div>
                    <div class="col-lg-12 col-xs-12">{{Form::bsText('Catalogo', 'catalogo', null, [], true)}}</div>
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

            var FormularioCatalogo = function(){

            };

            FormularioCatalogo.prototype.eliminacionCatalogo = function(){
                swal({
                    title: "Está seguro?",
                    text: "Por favor, confirme la eliminación de los Catalogos!",
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

            FormularioCatalogo.prototype.crearCanal = function(){
                $('form[name="formCrearCC"]').submit();
            };

            FormularioCatalogo.prototype.editarCanal = function(btn){
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

            FormularioCatalogo.prototype.seleccionarCC_Eliminar= function(btn){

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

            var objFormCC = new FormularioCatalogo();

            $(document).ready(function(){

                $('#btnEliminarCanales').click(function(){
                    objFormCC.eliminacionCatalogo();
                });

                $('#btnCrearCatalogo').click(function(){
                    $('select[name="idConjunto"] option:eq(0)').attr('selected', 'selected');
                    $('input[name="nombreCatalogo"]').val('');
                    $('form[name="formCrearCC"]').attr('action', '{{route('postCrearCC')}}');
                    $('#modalCatalogo').modal();
                });

                $('#btnSaveCanal').click(function(){
                    objFormCC.crearCanal();
                });

                $('.check-eliminarCC').click(function(){
                    $(this).blur();
                    objFormCC.seleccionarCC_Eliminar($(this));
                });

                $('.btn-editarCatalogo').click(function(){
                    $(this).blur();
                    objFormCC.editarCanal($(this));
                });

                {!! $scriptModal !!}
            });

        </script>
    @endpush

@endcomponent