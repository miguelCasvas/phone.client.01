@component('0_layouts.blank')
    @slot('activeCatalogo', 'active')
    @slot('activeAdminCatalogo', 'active')

    @slot('menuPagina')
        <h1>
            {{trans('catalogo.catalogo.catconjuntos')}}
            <small>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i> {{trans('generales.inicio')}}</a></li>
            <li class="active">{{trans('catalogo.catalogo.catalogos')}}</li>
            <li class="active">{{trans('catalogo.catalogo.catalogos')}}</li>
        </ol>
    @endslot

    @section('contenidoPagina')
        <div class="box">
            <div class="box-header with-border">
                <h3></h3>
                <div class="box-tools">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom"  title="{{trans('catalogo.catalogo.btneliminarmarcados')}}" id="btnEliminarCanales"><i class="fa fa-trash-o"></i></button>
                        <button type="button" class="btn btn-default btn-sm" title="{{trans('catalogo.catalogo.agregarcatalogo')}}" id="btnCrearCatalogo"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body row">
                <form action="#" name="formCatalogo" method="post">
                    {{ csrf_field() }}
                    <div class="col-lg-8 col-xs-12">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr class="info">
                                <th>{{trans('catalogo.catalogo.conjunto')}}</th>
                                <th>{{trans('catalogo.catalogo.catalogo')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($arregloCatalogos as $elemento)
                                <tr><td rowspan="{{count($elemento['catalogo']) + 1}}"><strong><u>{{$elemento['conjunto']}}</u></strong></td></tr>
                                @foreach($elemento['catalogo'] as $_elemento)
                                    <tr class="info">
                                        <td>
                                            <small><i class="fa  fa-check"></i></small> {{$_elemento['nombre_catalogo']}}
                                            <input type="checkbox" name="catalogo_conjunto[{{$_elemento['id_conjunto']}}][{{$_elemento['id_catalogo']}}]" value="eliminar" style="display: none" class="checksEliminarCatalogo" data-idcatalogo="{{$_elemento['id_catalogo']}}">
                                            <div class="btn-group btn-group-xs pull-right">
                                                <button type="button" class="btn btn-default check-eliminarCatalogo" data-toggle="tooltip" data-placement="top" title="{{trans('catalogo.catalogo.seleccionareliminar')}}"><i class="fa fa-square-o" aria-hidden="true"></i></button>
                                                <button
                                                        type="button"
                                                        class="btn btn-default btn-editarCatalogo"
                                                        data-conjunto = "{{$_elemento['id_conjunto']}}"
                                                        data-idcatalogo = "{{$_elemento['id_catalogo']}}"
                                                        data-catalogo = "{{$_elemento['nombre_catalogo']}}"
                                                ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                <button
                                                        type="button"
                                                        class="btn btn-default btn-sm btn-linkUbicacion"
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="{{trans('catalogo.catalogo.ubicaciones')}}"
                                                        data-href-ubic="{{route('getUbicacionCatalogo', ['porPagina' => 1000, 'idConjunto' => $_elemento['id_conjunto'], 'idCatalogo' => $_elemento['id_catalogo']])}}"
                                                        id=""><i class="fa fa-map-marker"></i></button>
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
            <!-- /.box-body -->
            <div class="box-footer clearfix">

            </div>
        </div>

        @component('0_partials.defaultModal', ['idModalDef' => 'modalCatalogo', 'titleModalDef' => '.:: Crear Catalogo ::.', 'idBtnSave' => 'btnSalvarCatalogo'])
            <form action="#" name="formCrearCatalogo" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xs-12">{{Form::bsSelect('Conjunto', 'idConjunto', $conjuntos, null, [], true)}}</div>
                    <div class="col-lg-12 col-xs-12">{{Form::bsText('Catalogo', 'nombreCatalogo', null, [], true)}}</div>
                </div>
            </form>
        @endcomponent
    @endsection

    @push('stylesheets')

    @endpush

    @push('scriptsPostLoad')
        <script>

            var FormularioCatalogo = function(){

            };

            FormularioCatalogo.prototype.eliminacionCatalogo = function(){
                swal({
                    title: "{{trans('catalogo.sweet_alert.error.tituloeliminar')}}",
                    text: "{{trans('catalogo.sweet_alert.error.textoeliminar')}}",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).
                then((willDelete) => {

                    if (willDelete) {
                        $('form[name="formCatalogo"]').attr('action', '{{route('postEliminacionCatalogo')}}');
                        $('form[name="formCatalogo"]').submit();
                    }
                });
            };

            /*
             * Valida si el catalogo a eliminar no tiene ubicaciones relicionadas
             * para permitir la eliminación
             */
            FormularioCatalogo.prototype.validarUbicacionCatalogo = function(check, btn){

                if($(check).is(":checked")){

                    idCatalogo = $(check).data('idcatalogo');

                    $.get('{{route('getUbicacionCatalogoFiltrado')}}?id_catalogo=' + idCatalogo, function(respuesta){
                        if(respuesta.data.length > 0){
                            swal({
                                title: "{{trans('catalogo.sweet_alert.error.tituloubicacion')}}",
                                text: "{{trans('catalogo.sweet_alert.error.textoubicacion')}}",
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            }).
                            then((moduloUbicacion) => {

                                if (moduloUbicacion) {
                                    window.location.href= '{{route('getUbicacionCatalogo')}}';
                                }

                                objFormCC.seleccionarCatalogo_Eliminar(btn);

                            });
                        }
                    })
                }

            };

            FormularioCatalogo.prototype.crearCatalogo = function(){
                $('form[name="formCrearCatalogo"]').submit();
            };

            FormularioCatalogo.prototype.editarCatalogo = function(btn){
                conjunto = $(btn).data('conjunto');
                catalogo = $(btn).data('catalogo');
                idCatalogo = $(btn).data('idcatalogo');

                cc = $(btn).data('cc');

                $('select[name="idConjunto"] option:eq('+ conjunto +')').attr('selected', 'selected');
                $('input[name="nombreCatalogo"]').val(catalogo);
                $('form[name="formCrearCatalogo"]').attr('action', '{{route('postEditarCatalogo', [''])}}/' + idCatalogo);
                $('#modalCatalogo').modal();
            };

            FormularioCatalogo.prototype.seleccionarCatalogo_Eliminar= function(btn){


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

                objFormCC.validarUbicacionCatalogo(elementCheck, btn);
            };

            FormularioCatalogo.prototype.redireccionUbicacion=function(btn){
                urlUbicacion = $(btn).data('href-ubic');
                window.location.href = urlUbicacion;
            };

            var objFormCC = new FormularioCatalogo();

            $(document).ready(function(){

                $('#btnEliminarCanales').click(function(){
                    objFormCC.eliminacionCatalogo();
                });

                $('#btnCrearCatalogo').click(function(){
                    $('select[name="idConjunto"] option:eq(0)').attr('selected', 'selected');
                    $('input[name="nombreCatalogo"]').val('');
                    $('form[name="formCrearCatalogo"]').attr('action', '{{route('postCrearCatalogo')}}');
                    $('#modalCatalogo').modal();
                });

                $('#btnSalvarCatalogo').click(function(){
                    objFormCC.crearCatalogo();
                });

                $('.check-eliminarCatalogo').click(function(){
                    $(this).blur();
                    objFormCC.seleccionarCatalogo_Eliminar($(this));
                });

                $('.btn-editarCatalogo').click(function(){
                    $(this).blur();
                    objFormCC.editarCatalogo($(this));
                });

                $('.btn-linkUbicacion').click(function(){
                    objFormCC.redireccionUbicacion($(this));
                });

                {!! $scriptModal !!}
            });

        </script>
    @endpush

@endcomponent