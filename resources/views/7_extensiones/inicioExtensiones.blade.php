@component('0_layouts.blank')
    @slot('activeExtensiones', 'active')

    @slot('menuPagina')
        <h1>
            EXTENSIONES
            <small>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i>{{trans('generales.inicio')}}</a></li>
            <li class="active">Extensiones</li>
        </ol>
    @endslot

@section('contenidoPagina')

    <div class="row">
        <div class="col-md-3">
            <div class="input-group input-group-md margin-bottom">
                <input name="table_search" class="form-control pull-right" placeholder="Buscar Conjunto" type="text">

                <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Conjuntos</h3>

                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        @foreach($conjuntos as $conjunto)
                            <li><a href="#" data-idconjunto = "{{$conjunto->id_conjunto}}" class="linkVistaExtensiones"><i class="fa fa-building-o"></i> {{$conjunto->nombre_conjunto}}</a></li>
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
                    <h3 class="box-title">Extensiones conjunto <span class="text-muted"> .:: <span id="nombreConjunto"></span> ::. </span></h3>

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
                        <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm btnEliminarExten" title="Eliminar extensión"><i class="fa fa-trash-o"></i></button>
                            <button type="button" class="btn btn-default btn-sm btnEliminarRelExten" title="Eliminar Relación de extensión"><i class="fa fa-user-times" aria-hidden="true"></i></button>
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
                                    <td align="center" class="text-muted"><h4>Estensiones</h4></td>
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
                        <button type="button" class="btn btn-default btn-sm checkbox-toggle btnEliminarExten"><i class="fa fa-square-o"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm btnEliminarExten" title="Eliminar extensión"><i class="fa fa-trash-o"></i></button>
                            <button type="button" class="btn btn-default btn-sm btnEliminarRelExten" title="Eliminar Relación de extensión"><i class="fa fa-user-times" aria-hidden="true"></i></button>
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
@endsection

@push('stylesheets')
    <link rel="stylesheet" href="{{asset('plugins/iCheck/flat/blue.css')}}">
    <style>
        .nav > li > a.conjuntoSelecccionado{
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

        Extensiones = function(){
            this.paramsUrl = null;
            this.formExtensiones = $('form[name="formExtensiones"]');
            this.linkConjunto = $('.linkVistaExtensiones');
            this.tbodyExten = $('#tbodyExtensiones');
            this.nombreConjunto = $('#nombreConjunto');
            this.btnElimExten = $('.btnEliminarExten');
            this.btnElimRelExten = $('.btnEliminarRelExten');
            this.checkExtension = $('.checkExtension');
        };

        Extensiones.prototype.cargueParamsUrl = function(params, vlr){
          this.paramsUrl[params] = vlr;
        };

        Extensiones.prototype.cargueExtensiones = function(){

            $(this.linkConjunto).click(function(event){

                $(objExtensiones.linkConjunto).removeClass('conjuntoSelecccionado');
                $(this).addClass('conjuntoSelecccionado');

                event.preventDefault();

                idConjunto = $(this).data('idconjunto');
                url = '{{route('getExtensionFtUsuarioConjunto')}}';
                params = {id_conjunto:idConjunto};

                tbody =
                    '<tr>' +
                    '<td align="center" style="height: 49px;">' +
                    '<div><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>' +
                    '<span class="sr-only">Loading...</span></div></td>' +
                    '<tr>';
                $(objExtensiones.tbodyExten).html(tbody);
                $.get(url, params, objExtensiones.esquemaTabla);
            });

        };

        Extensiones.prototype.esquemaTabla = function(response){

            var tbody = '';
            $(objExtensiones.nombreConjunto).html(response.data[0].nombre_conjunto);


            $.each(response.data, function(pos, elemento){

                tdNombres = (elemento.nombres === null) ? 'Sin Asignar' : '<b>' + elemento.nombres + '</b> - Apto #';
                nomCheck = 'extension['+elemento.id_extension+']['+elemento.id_usuario_extension+']['+elemento.id_usuario+']';
                dataLink = 'data-relacion="'+elemento.id_usuario_extension+'"';

                tbody += '<tr>';
                tbody += '<td><input type="checkbox" name="'+nomCheck+'" '+dataLink+'></td>';
                tbody += '<td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>';
                tbody += '<td><a href="#">' + elemento.extension + '</a></td>';
                tbody += '<td class="mailbox-subject">'+ tdNombres +'</td>';
                tbody += '<td class="mailbox-attachment"></td>';
                tbody += '<td class="mailbox-attachment"></td>';
                tbody += '<td class="mailbox-date"></td>';
                tbody += '</tr>';

            });

            $(objExtensiones.tbodyExten).html(tbody);
            objExtensiones.checkEliminacion(false);
            objExtensiones.paramsUrl;
        };

        Extensiones.prototype.checkEliminacion = function(btnEliminacionMasiva){

            if(btnEliminacionMasiva == true){
                /*
                 * Seleccion o Deseleccion de check eliminacion masivamente
                 */
                $(".checkbox-toggle").click(function () {
                    var clicks = $(this).data('clicks');
                    if (clicks) {
                        //Uncheck all checkboxes
                        $(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
                        $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
                    } else {
                        //Check all checkboxes
                        $(".mailbox-messages input[type='checkbox']").iCheck("check");
                        $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
                    }
                    $(this).data("clicks", !clicks);
                });
            }

            /*
             * Inicializacion de componente para visualizacion de checks
             */
            $(".mailbox-messages input[type='checkbox']").iCheck({checkboxClass: 'icheckbox_flat-blue'});
        };

        Extensiones.prototype.eliminarExtensiones = function(){

            $(this.btnElimExten).click(function(){

            });

        };

        Extensiones.prototype.eliminarRelExtensiones = function(){
            $(this.btnElimRelExten).click(function(){
                $(objExtensiones.formExtensiones).attr('action', '{{route('delRelExtensiones')}}');
                $(objExtensiones.formExtensiones).submit();
            });

        };

        var objExtensiones = new Extensiones();

        $(function(){

            objExtensiones.cargueExtensiones();
            objExtensiones.checkEliminacion(true);
            objExtensiones.eliminarRelExtensiones();

            //Handle starring for glyphicon and font awesome
            $(".mailbox-star").click(function (e) {
                e.preventDefault();
                //detect type
                var $this = $(this).find("a > i");
                var glyph = $this.hasClass("glyphicon");
                var fa = $this.hasClass("fa");

                //Switch states
                if (glyph) {
                    $this.toggleClass("glyphicon-star");
                    $this.toggleClass("glyphicon-star-empty");
                }

                if (fa) {
                    $this.toggleClass("fa-star");
                    $this.toggleClass("fa-star-o");
                }
            });

        });

    </script>

@endpush
@endcomponent