@component('0_layouts.blank')
    @slot('activeCC', 'active')
    @slot('activeTpoSalida', 'active')

    @slot('menuPagina')
        <h1>
            TIPOS DE SALIDA PARA CALANDES DE COMUNICACIÓN
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
                <div class="col-lg-4">
                    <form action="{{route('postTiposSalida')}}" method="post">

                        {{csrf_field()}}

                        {{-- NOMBRE DEL TIPO DE IDENTIFICACION --}}
                        {{ Form::bsText('Nombre tipo Salida', 'nombreTipoSalida', null, [], true) }}

                        {{-- METODO A DESARROLLADO --}}
                        {{ Form::bsText('Metodo de salida', 'metodo', null, [], true) }}

                        {{-- PARAMETROS PARA METODO --}}
                        {{ Form::bsText('Variables metodo', 'metodoParams', null, [], true) }}

                        {{-- CONJUNTOS --}}
                        {{Form::bsSelect('Conjunto', 'idConjunto', $conjuntos, $idConjunto, [], true)}}

                        {{-- CANAL DE COMUNICACIÓN PARA ELEGIR --}}
                        {{Form::bsSelect('Canal de comunicación', 'idCanal', $canalesComunicacion, null, [], true)}}

                        <button class="btn btn-primary pull-right" type="submit">Confirmar</button>
                    </form>
                </div>
                
                <div class="col-lg-8">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Método</th>
                                <th>Datos método</th>
                                <th>Canal de comunicación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($listado as $tpoSalida)
                                <tr>
                                    <td>{{$tpoSalida->nombre_tipo_salida}}</td>
                                    <td>{{$tpoSalida->metodo}}</td>
                                    <td>{{$tpoSalida->metodo_params}}</td>
                                    <td>{{$tpoSalida->canal}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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