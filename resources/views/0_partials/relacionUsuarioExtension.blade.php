<form action="{{route('postUsuarioExten', [$idUsuario])}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" value="{{$idConjunto}}" name="idConjunto">
    @component('0_partials.defaultModal')
        @slot('idModalDef', 'ModalExten')
        @slot('typeButton', 'submit')
        @slot('titleModalDef', '<i class="fa fa-cog" aria-hidden="true"></i> ' . trans('usuario.transversales.tituloRelExten', ['usuario' => $nomUsuario]))
        @slot('btnsAdd')
            <button type="button" class="btn btn-default pull-left" id="btnClearFormUbic" title="limpiar Formulario ">
                <i class="fa fa-eraser"></i>
            </button>
        @endslot

        <div id="contentCatalago">
            <!-- CONTENIDO CATALOGO -->
        </div>
    @endcomponent
</form>

@section('scriptRelExten')
    <script>

        var RelExtesion = function(){
            this.divCatalogo = $('#contentCatalago');
        };

        /*
         * REALIZA LA BUSQUEDA DE LOS CATALOGOS DE ACUERDO AL
         * CONJUNTO SELECCIONADO
         */
        RelExtesion.prototype.busquedaExten = function(idConjunto){

            /*
             * Consulta de extensiones del conjunto seleccionado
             * idConjunto ==> variable global
             */
            ruta = '{{route('getSelectsCatalogosConjunto', ['%idConjunto%'])}}';
            rutaFinal = ruta.replace('%idConjunto%', idConjunto);

            $.get( rutaFinal , function(response){
                $('#contentCatalago').html(response);
            }).
            fail(function(response){
                console.log(response);
                swal ( "{{trans('generales.sweet_alert.error.titulo')}}" ,  "{{trans('generales.sweet_alert.error.texto')}}" ,  "error" );
                return null;
            });

        };

        /*
         * CARGA LOS OPTION DEL CAMPO UBICACION CATALOGO DEPENDIENDO
         * CATALOGO SELECCIONADO
         */
        RelExtesion.prototype.busquedaUbicCat = function(campSelect){
            var idSelectCatalogo = $(campSelect).data('select-ubic');
            idCatalogo = $(campSelect).val();
            url = '{{route('getUbicacionCatalogoFiltrado')}}?id_catalogo=' + idCatalogo;

            $('#' + idSelectCatalogo).html('');
            $('#' + idSelectCatalogo).append('<option value="">Selección</option>');
            this.defineSegmentoExt($('#' + idSelectCatalogo));

            $.get(url, function(ubicaconesCatalogo){
                if(ubicaconesCatalogo !== null){
                    $.each(ubicaconesCatalogo.data, function(id, ubicacion){
                        option = '<option value='+ubicacion.id_ubicacion_catalogo+' data-vlr-ext="'+ubicacion.valor_extension+'">'+ubicacion.nombre_ubicacion_catalogo+'</option>';
                        $('#' + idSelectCatalogo).append(option);
                    });
                }
            }).fail(function(){
                    swal ( "{{trans('generales.sweet_alert.error.titulo')}}" ,  "{{trans('generales.sweet_alert.error.texto')}}" ,  "error" );
                    return null;
            });
        };

        /*
         * DEFINE EL VALOR DEL SEGMENTO DE LA EXTENSION SEGUN LA UBICACION
         * SELECCIONADA
         */
        RelExtesion.prototype.defineSegmentoExt = function(campSelect){
            txtVlrExtension = $(campSelect).data('segment-ext');
            vlrExtension = $(campSelect).find('option:selected').data('vlr-ext');
            $('#' + txtVlrExtension).val(vlrExtension);
        };

        /*
         * LIMPIA TODOS LOS CAMPOS DEL FORMULARIO CREACION DE EXTENSION
         */
        RelExtesion.prototype.limpiarForm = function(){
            $('.selectCat').each(function(index, elemento){
                $(elemento).val('');
                elementUbicCat = $('#' + $(elemento).data('select-ubic'));

                (new RelExtesion()).busquedaUbicCat($(elemento));
            });
        };

        {{--
            SE VAIDA SI EXISTEN ERRORES EN EL FORMULARIO ENVIADO SI ES ASI
            SE DESPLIEGA EL MODAL DE EXTENSIONES
        --}}
        @if($errors->first('idExtension'))
        $('#ModalExten').modal();
        @endif

    </script>
@endsection