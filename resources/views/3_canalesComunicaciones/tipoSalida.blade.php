@component('0_layouts.blank')
    @slot('activeCC', 'active')
    @slot('activeTpoSalida', 'active')

    @slot('menuPagina')
        <h1>
            TIPOS DE SALIDA PARA CANALES DE COMUNICACIÓN
            <small>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i> {{trans('generales.inicio')}}</a></li>
            <li class="active">tipos de salida canal comunicación</li>
        </ol>
    @endslot

@section('contenidoPagina')
    <div class="box">
        <div class="box-header with-border">
            <h3></h3>
            <div class="box-tools">
                <div class="btn-group"></div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12">
                    <form action="{{route('postTiposSalida')}}" method="post">

                        <div class="row">
                            <div class="col-lg-4">
                                {{csrf_field()}}

                                {{-- CONJUNTOS --}}
                                {{Form::bsSelect('Conjunto', 'idConjunto', $conjuntos, $idConjunto, [], true)}}

                                {{-- CANAL DE COMUNICACIÓN PARA ELEGIR --}}
                                {{Form::bsSelect('Canal de comunicación', 'idCanal', $canalesComunicacion, null, [], true)}}

                            </div>

                            <div class="col-lg-4">
                                {{-- NOMBRE DEL TIPO DE IDENTIFICACION --}}
                                {{ Form::bsText('Nombre tipo Salida', 'nombreTipoSalida', null, [], true) }}

                                {{-- METODO A DESARROLLADO --}}
                                {{ Form::bsText('Metodo de salida', 'metodo', null, [], true) }}
                            </div>

                            <div class="col-lg-4">

                                {{-- PARAMETROS PARA METODO --}}
                                {{ Form::bsText('Variables metodo', 'metodoParams', null, [], true) }}

                                <div class="form-group">
                                    <textarea
                                            name="comentarios"
                                            class="form-control" rows="3"
                                            placeholder="Digite aquí el contenido descriptivo de la salida"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12 pull-right">
                                <button class="btn btn-primary pull-right" type="submit">Confirmar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12" style="margin-top: 15px;">
                    <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Método</th>
                                <th>Datos método</th>
                                <th>Canal de comunicación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($listado as $tpoSalida)
                                <tr>
                                    <td data-campo="">{{$tpoSalida->nombre_tipo_salida}}</td>
                                    <td data-campo="">{{$tpoSalida->metodo}}</td>
                                    <td data-campo="">{{$tpoSalida->metodo_params}}</td>
                                    <td data-campo="">{{$tpoSalida->canal}}</td>
                                    <td data-campo="">
                                        <div class="btn-group" role="group" aria-label="...">
                                            <button type="button" class="btn btn-danger btn-xs">Borrar</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">

        </div>
    </div>

@endsection

@push('stylesheets')

@endpush

@push('scriptsPostLoad')
    <script>
        var FormularioTpoSalida = function(){

        };

        FormularioTpoSalida.prototype.cargueCanales = function(selectConjunto){
            idConjunto = $(selectConjunto).find('option:selected').val();
            window.location.href = '{{route('getTiposSalida')}}?id_conjunto=' + idConjunto;
        };


        objForm = new FormularioTpoSalida();

        $(function(){
           $('select[name="idConjunto"]').change(function(){
               objForm.cargueCanales($(this));
           });
        });
    </script>
@endpush

@endcomponent