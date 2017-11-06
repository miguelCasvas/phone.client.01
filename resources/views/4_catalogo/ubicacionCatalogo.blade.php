@component('0_layouts.blank')
    @slot('activeCatalogo', 'active')
    @slot('activeAdminUbicacion', 'active')

    @slot('menuPagina')
        <h1>
            {{trans('catalogo.catalogo.ubicacioncatalogo')}}
            <small>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i> {{trans('generales.inicio')}}</a></li>
            <li class="active">{{trans('catalogo.catalogo.catalogos')}}</li>
            <li class="active">{{trans('catalogo.catalogo.ubicacioncatalogo2')}}</li>
        </ol>
    @endslot

@section('contenidoPagina')
    <div class="row">
        <div class="col-md-3">

            {{Form::bsSelect('Conjunto Residencial', 'idConjunto', $conjuntos, $conjuntoSelected, [], false)}}

            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Catalogos</h3>

                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        @foreach($catalogo as $elemento)
                            <li>
                                @php $classCatalogo = ($idCatalogo == $elemento->id_catalogo) ? 'catalogoSelecccionado' : '' @endphp
                                <a
                                        href="{{route('getUbicacionCatalogo', ['porPagina' => 1000, 'idConjunto' => $conjuntoSelected, 'idCatalogo' => $elemento->id_catalogo])}}"
                                        data-idconjunto = "#"
                                        class="linkVistaUbicaciones {{$classCatalogo}}"><i class="fa fa-mouse-pointer"></i> {{$elemento->nombre_catalogo}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Ubicaciones Catalogo <span class="text-muted"> .:: <span id="catalogo"></span> ::. </span></h3>

                    <div class="box-tools pull-right">
                        <div class="has-feedback">
                            <input class="form-control input-sm" placeholder="Buscar extension" type="text">
                            <span class="glyphicon glyphicon-search form-control-feedback"></span>
                        </div>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="mailbox-controls">
                        <!-- Check all button -->
                        <button type="button" class="btn btn-default btn-sm checkbox-toggle" disabled><i class="fa fa-square-o"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm btnEliminarExten" title="Eliminar extensión" disabled><i class="fa fa-trash-o"></i></button>
                            <button type="button" class="btn btn-default btn-sm btnCrearUbicCat" title="Crear Ubicacion para Catalogo"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </div>
                        <!-- /.btn-group -->
                        <div class="pull-right">
                            1-50/200
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                            </div>
                            <!-- /.btn-group -->
                        </div>
                        <!-- /.pull-right -->
                    </div>
                    <div class="table-responsive mailbox-messages">
                        <form action="" method="post" name="formExtensiones">
                            {{ csrf_field() }}
                            <table class="table table-hover table-striped">
                                <tbody id="tbodyExtensiones">
                                {!! $contentTdUbicacion !!}
                                </tbody>
                            </table>
                        </form>
                        <!-- /.table -->
                    </div>
                    <!-- /.mail-box-messages -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer no-padding">
                    <div class="mailbox-controls">
                        <!-- Check all button -->
                        <button type="button" class="btn btn-default btn-sm checkbox-toggle" disabled><i class="fa fa-square-o"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm btnEliminarExten" title="Eliminar extensión" disabled><i class="fa fa-trash-o"></i></button>
                            <button type="button" class="btn btn-default btn-sm btnCrearUbicCat" title="Crear Ubicacion para Catalogo"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </div>

                        <div class="pull-right">
                            1-50/200
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                            </div>
                            <!-- /.btn-group -->
                        </div>
                        <!-- /.pull-right -->
                    </div>
                </div>
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>

    <form action="" method="post" name="FormUbicCat" data-accion="">
    @component('0_partials.defaultModal')
        {{ csrf_field() }}
            @slot('idModalDef', 'ModalUbicacionCat')
            @slot('typeButton', 'submit')
            @slot('titleModalDef', '<i class="fa fa-cog" aria-hidden="true"></i> ')

                {{-- NOMBRE UBICACION CATALOGO --}}
                {{ Form::bsText('Ubicación Catalogo', 'nombreUbicacionCatalogo', null, [], true) }}

                {{-- VLR UBICACION CATALOGO --}}
                {{ Form::bsText('Segmento Extensión', 'valorExtension', null, [], false) }}
                <input type="hidden" name="idCatalogo" value="{{$idCatalogo}}">

    @endcomponent
    </form>
@endsection

@push('stylesheets')
    <link rel="stylesheet" href="{{asset('plugins/iCheck/flat/blue.css')}}">
    <style>
        .nav > li > a.catalogoSelecccionado{
            background: #3c8dbc ;
            color: #fff;
        }

        .nav > li > a {
            border-left-color: #3c8dbc;
        }

    </style>
@endpush

@push('scriptsPostLoad')
    <script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>
    <script>

        FormUbicacionCat = function(){
            this.confirEnvio = false;
        };

        FormUbicacionCat.prototype.redirectPorSelect = function(btn){
            url = '{{route('getUbicacionCatalogo', ['porPagina' => 1000])}}&idConjunto=' + $(btn).val();
            window.location.href = url;
        };

        FormUbicacionCat.prototype.editUbic= function(btn){

            url = '{{route('postUbicacionCatalogo', ['%idUbicCat%'])}}';
            rutaFinal = url.replace('%idUbicCat%', $(btn).data('id-ubic'));

            $('Form[name="FormUbicCat"]').attr('action', rutaFinal);
            $('Form[name="FormUbicCat"]').attr('data-accion', 'edicion');
            $('input[name="nombreUbicacionCatalogo"]').val($(btn).data('nom-ubic'));
            $('input[name="valorExtension"]').val($(btn).data('vlr-ubic'));

            $('#ModalUbicacionCat').modal();

        };

        FormUbicacionCat.prototype.creaUbic= function(){
            url = '{{route('postCrearUbicacionCatalogo')}}';

            $('Form[name="FormUbicCat"]').attr('action', url);
            $('Form[name="FormUbicCat"]').attr('data-accion', 'creacion');

            $('input[name="nombreUbicacionCatalogo"]').val('');
            $('input[name="valorExtension"]').val('');

            $('#ModalUbicacionCat').modal();
        };

        FormUbicacionCat.prototype.envioFormUbic= function(Formulario){
            $('#ModalUbicacionCat').modal('hide');

            swal({
                title: "Confirmación!",
                text: "Está edicion, puede generar el cambio de las extensiones",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((editar) => {
                if(editar){
                    objFormUbicacionCat.confirEnvio = true;
                    $(Formulario).submit();
                }
            });

        };

        var objFormUbicacionCat = new FormUbicacionCat();

        $(function(){
            /*
             * Inicializacion de componente para visualizacion de checks
             */
            $(".mailbox-messages input[type='checkbox']").iCheck({checkboxClass: 'icheckbox_flat-blue'});

            $("select[name='idConjunto']").change(function(){
                objFormUbicacionCat.redirectPorSelect($(this));
            });

            $('.btn-edit-ubic').click(function(){
                objFormUbicacionCat.editUbic($(this));
            });

            $('.btnCrearUbicCat').click(function(){
                objFormUbicacionCat.creaUbic();
            });

            $('Form[name="FormUbicCat"]').submit(function($event){
                if(objFormUbicacionCat.confirEnvio == false && $(this).data('accion') == 'edicion'){
                    $event.preventDefault();
                    objFormUbicacionCat.envioFormUbic($(this));
                }
            });

            /*
             * Despliegue automatico de modal ModalUbicacionCat
             * si se generan errores
             */
            {!! $scriptModalUbicCat !!}
        });
    </script>
@endpush

@endcomponent