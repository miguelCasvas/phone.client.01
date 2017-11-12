@component('0_layouts.blank')

    @slot('menuPagina')
        <h1>Genera Marcados <small>#Extension</small></h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i> {{trans('generales.inicio')}}</a></li>
            <li class="active">Marcados</li>
        </ol>
    @endslot

@section('contenidoPagina')
    <div class="box">
        <div class="box-header with-border">
            <h3></h3>
            <div class="box-tools">
                <button type="button" class="btn btn-primary btn-sm" title="Confirma cambios" id="btnCrearCanal"><i class="fa fa-check"></i></button>
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
                            {{Form::bsSelect('Conjunto', 'idConjunto', $conjuntos, $idConjunto, [], false)}}

                            <!-- the events -->
                            <div id="">
                                @php $contador = 0; @endphp
                                @foreach($tiposSalida as $tipoSalida)
                                    @php $color = (($contador % 2) == 0) ? 'bg-light-blue' : 'bg-red'@endphp

                                    <div
                                            class="external-event {{$color}} ui-draggable ui-draggable-handle"
                                            style="position: relative; cursor: pointer;">
                                                {{$tipoSalida->nombre_tipo_salida}}
                                                <i class="pull-right fa fa-mouse-pointer" aria-hidden="true"></i>
                                    </div>
                                    @php $contador += 1; @endphp
                                @endforeach
                            </div>
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
                    </div>

                        <ul class="list-group" id="marcadosUsuario">
                            <li class="list-group-item" style="cursor: n-resize;">Cras justo odio
                                <a class="text-danger pull-right eliminaMarcado" style="cursor: pointer"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </li>
                            <li class="list-group-item" style="cursor: n-resize;">Dapibus ac facilisis in
                                <a class="text-danger pull-right eliminaMarcado" style="cursor: pointer"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </li>
                            <li class="list-group-item" style="cursor: n-resize;">Morbi leo risus
                                <a class="text-danger pull-right eliminaMarcado" style="cursor: pointer"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </li>
                            <li class="list-group-item" style="cursor: n-resize;">Porta ac consectetur ac
                                <a class="text-danger pull-right eliminaMarcado" style="cursor: pointer"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </li>
                            <li class="list-group-item" style="cursor: n-resize;">Vestibulum at eros
                                <a class="text-danger pull-right eliminaMarcado" style="cursor: pointer"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </li>
                        </ul>
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

            window.location.href = '{{route('getInicioMarcados')}}?id_conjunto=' + idConjunto;
        };

        var objFormMarcados = new FormMarcado();

        $( function() {

            $('select[name="idConjunto"]').change(function(){
                objFormMarcados.cargueTposMarcado($(this));
            });

            $( "#marcadosUsuario" ).sortable();
            $( "#marcadosUsuario" ).disableSelection();

            $('.external-event').click(function(){
                newLi = $('<li class="list-group-item" style="cursor: n-resize;">nuevo elemento' +
                    '<a class="text-danger pull-right eliminaMarcado" style="cursor: pointer"><i class="fa fa-trash" aria-hidden="true"></i></a>' +
                    '</li>');
                $('#marcadosUsuario').append(newLi);
            });

            $("#marcadosUsuario").delegate('.eliminaMarcado', 'click', function(){
                $(this).parent().remove();
            });

        } );
    </script>
@endpush
@endcomponent