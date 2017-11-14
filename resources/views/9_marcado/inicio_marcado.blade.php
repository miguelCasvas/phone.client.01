@component('0_layouts.blank')

    @slot('menuPagina')
        <h1>Genera Marcados <small>#Extension</small></h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i> {{trans('generales.inicio')}}</a></li>
            <li class="active">Mi plan de marcado</li>
        </ol>
    @endslot

@section('contenidoPagina')
    <div class="box">
        <div class="box-header with-border">
            <h3></h3>
            <div class="box-tools">
                <button type="button" class="btn btn-primary btn-sm" title="Confirma cambios" id="btnConfirmarOrdem"><i class="fa fa-check"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h4 class="box-title">Marcados disponibles</h4>
                        </div>
                        <div class="box-body">
                            {{-- CONJUNTOS --}}
                            {{Form::bsSelect('Conjunto', 'idConjunto', $conjuntos, $idConjunto, [], true)}}

                            {{-- EXTENSIONES --}}
                            {{Form::bsSelect('Extensiones', 'selectExtension', $extensiones, $extensionGet, [], true)}}


                            <!-- the events -->
                            @php $contador = 0; @endphp
                            @foreach($tiposSalida as $tipoSalida)
                                @php $color = (($contador % 2) == 0) ? 'bg-light-blue' : 'bg-red'@endphp
                                <div
                                        class="external-event {{$color}} ui-draggable ui-draggable-handle"
                                        style="position: relative; cursor: pointer;"
                                        data-marcado="{{$tipoSalida->nombre_tipo_salida}}"
                                        data-comentario="{{$tipoSalida->comentarios}}"
                                        data-metodo="{{$tipoSalida->metodo}}"
                                        data-metodo-params="{{$tipoSalida->metodo_params}}"
                                >
                                    {{$tipoSalida->nombre_tipo_salida}}
                                    <i class="pull-right fa fa-mouse-pointer" aria-hidden="true"></i>
                                </div>
                                @php $contador += 1; @endphp
                            @endforeach
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /. box -->
                    <div class="box box-solid">
                        <div class="box-body alert alert-info hidden-xs">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            De click a uno de los items de la parte superior para añadir el marcado a su extensión
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h4 class="box-title">Sus Marcados</h4>
                        </div>
                        <div class="box-body">
                            <ul class="list-group" id="marcadosUsuario">
                                <!--ITEMS MARCADO-->
                                @foreach($planMarcado as $plan)
                                        <li class="list-group-item" style="cursor: n-resize;" id="marcado_{{$plan->id}}">
                                            <form action="{{route('eliminarMarcado', [$plan->id])}}" method="post">
                                                {{method_field('DELETE')}}
                                                {{csrf_field()}}
                                                <div class="row">
                                                <div class="col-lg-4"><span class="text-muted">Extensión:</span> {{$plan->exten}}</div>
                                                <div class="col-lg-4"><span class="text-muted">Destino:</span> {{$plan->data_visual}}</div>
                                                <div class="col-lg-4"><button class="btn btn-danger btn-xs pull-right" type="submit">Borrar</button></div>
                                                </div>
                                            </form>
                                        </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">

        </div>
    </div>
@endsection

@push('stylesheets')

@endpush

@push('scriptsPostLoad')
    <script src="{{asset('bower_components/jquery-ui/jquery-ui.js')}}"></script>
    <script>

        var FormMarcado = function(){

        };

        FormMarcado.prototype.cargueTposMarcado = function(selectConjunto){
            idConjunto = $(selectConjunto).find('option:selected').val();
            url = '{{request()->url()}}';
            extension = '{{request()->get('extension')}}';

            if(extension !== '')
                window.location.href = url + '?id_conjunto=' + idConjunto + '&extension=' + extension;
            else
                window.location.href = url + '?id_conjunto=' + idConjunto;
        };

        FormMarcado.prototype.renderItem = function(tipoMarcado){

            texto = $(tipoMarcado).data('marcado');
            comentario = $(tipoMarcado).data('comentario');
            metodo = $(tipoMarcado).data('metodo');
            metodoParams = $(tipoMarcado).data('metodo-params');

            newLi = '@include('0_partials.itemMarcado', ['textoMarcado' => '%textoMarcado%', 'scriptMarcado' => true])';
            newLi = newLi.replace('%textoMarcado%', texto);
            newLi = newLi.replace('%comentario%', comentario);
            newLi = newLi.replace('%metodo%', metodo);
            newLi = newLi.replace('%metodoParams%', metodoParams);

            $('#marcadosUsuario').append(newLi);

        };

        FormMarcado.prototype.editarMarcado = function(btn){

            placeHolder = $(btn).data('comentario');
            metodo = $(btn).data('metodo');
            metodoParams = $(btn).data('metodo-params');

            esquemaLi = '@include('0_partials.itemMarcado', ['scriptEditarMarcado' => true])';
            esquemaLi = esquemaLi.replace('%comentarioMarcado%', placeHolder);
            esquemaLi = esquemaLi.replace('%metodo%', metodo);
            esquemaLi = esquemaLi.replace('%metodoParams%', metodoParams);
            liParent = $(btn).parent().parent();
            $(liParent).append(esquemaLi);
            $(btn).attr('disabled', true);

        };

        FormMarcado.prototype.seleccionExtension = function(selectExtensiones){
            extension = $(selectExtensiones).find('option:selected').val();
            $('.inputExtension').val(extension);
        };

        FormMarcado.prototype.cambioExtension = function(selectExtensiones){
            extension = $(selectExtensiones).find('option:selected').val();
            url = '{{request()->url()}}';
            idConjunto = '{{request()->get('id_conjunto')}}';

            if(idConjunto !== '')
                window.location.href = url + '?id_conjunto=' + idConjunto + '&extension=' + extension;
            else
                window.location.href = url + '?extension=' + extension;

        };

        FormMarcado.prototype.confirmarOrden = function(){
            orden = $('#marcadosUsuario').sortable("serialize", {key:"Marcado[]"});

            $.get('{{route('generarOrden')}}?' + orden, function(response){

                swal ( "" ,  "Ordenado correctamente!" ,  "success" )

            });
        };

        btnConfirmarOrdem

        var objFormMarcados = new FormMarcado();

        $( function() {

            $('select[name="idConjunto"]').change(function(){
                objFormMarcados.cargueTposMarcado($(this));
            });

            $('select[name="selectExtension"]').change(function(){
                objFormMarcados.cambioExtension($(this));
            });

            $("#marcadosUsuario").delegate('.formMarcador', 'submit', function(){
                objFormMarcados.seleccionExtension($('select[name="selectExtension"]'));
            });

            $( "#marcadosUsuario" ).sortable();
            $( "#marcadosUsuario" ).disableSelection();

            $('.external-event').click(function(){
                objFormMarcados.renderItem($(this));
            });

            $("#marcadosUsuario").delegate('.eliminaMarcado', 'click', function(){
                $(this).parent().parent().remove();
            });

            $("#marcadosUsuario").delegate('.editarMarcado', 'click', function(){
                objFormMarcados.editarMarcado($(this));
            });

            $("#btnConfirmarOrdem").click(function(){
                objFormMarcados.confirmarOrden();
            });

        } );
    </script>
@endpush
@endcomponent