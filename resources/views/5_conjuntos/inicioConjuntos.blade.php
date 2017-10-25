@component('0_layouts.blank')
    @slot('activeConjuntos', 'active')

    @slot('menuPagina')
        <h1>
            CONJUNTOS
            <small>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i>{{trans('generales.inicio')}}</a></li>
            <li class="active">Conjuntos</li>
        </ol>
    @endslot

@section('contenidoPagina')
    <div class="row">
        <section class="col-lg-12 connectedSortable ui-sortable">
            <div class="nav-tabs-custom" style="">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="{{$formCreacion}}"><a href="#crearConjunto" data-toggle="tab"><i class="fa fa-building-o" aria-hidden="true"></i> Crear Conjunto</a></li>
                    <li class="{{$listaConjutos}}"><a href="#listadoConjunto" data-toggle="tab"><i class="fa fa-list" aria-hidden="true"></i> Conjuntos</a></li>
                    <li class="pull-left header"><i class="fa fa-building-o" aria-hidden="true"></i></li>
                </ul>
                <div class="tab-content no-padding">

                    <div class="chart tab-pane box {{$listaConjutos}}" id="listadoConjunto" >
                        <div class="box-header">
                            <h3 class="box-title"></h3>

                            <div class="box-tools">

                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input name="table_search" class="form-control pull-right" placeholder="Search" type="text">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                @php $contador = 0;
                                    dd($conjuntos);
                                @endphp
                                @foreach($conjuntos as $conjunto)
                                <div class="col-lg-6">
                                    <div class="box box-widget widget-user-2">
                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                        <div class="widget-user-header bg-yellow">
                                            <div class="widget-user-image">
                                                <img class="img-circle" style="background: white !important" src="{{asset('img/edificacion_01.png')}}" alt="User Avatar">
                                            </div>
                                            <!-- /.widget-user-image -->
                                            <h3 class="widget-user-username" style="font-weight: bold">
                                                {{$conjunto->nombre_conjunto}}
                                                <a
                                                        href="{{route('getEliminarConjunto', [$conjunto->id_conjunto])}}"
                                                        class="pull-right linkEliminarConjunto"
                                                        style="color: white"
                                                        title="Eliminar {{$conjunto->nombre_conjunto}}"
                                                        data-cc = "{{$conjunto->catalogos_comunicacion}}"
                                                        data-catalogo = "{{$conjunto->catalogos}}"
                                                        data-extensiones = "{{$conjunto->extensiones}}"
                                                ><i class="fa fa-trash-o"></i></a>
                                            </h3>
                                            <h5 class="widget-user-desc">{{$conjunto->direccion}}</h5>
                                        </div>
                                        <div class="box-body no-padding">
                                            <ul class="nav nav-stacked">
                                                <li><a href="{{route('getModuloCC')}}">Canales de comunicación <span class="pull-right badge bg-blue">{{$conjunto->catalogos_comunicacion}}</span></a></li>
                                                <li><a href="{{route('getModuloCatalogos')}}">Catalogo del conjunto<span class="pull-right badge bg-green">{{$conjunto->catalogos}}</span></a></li>
                                                <li><a href="#">Extensiones <span class="pull-right badge bg-red">{{$conjunto->extensiones}}</span></a></li>
                                            </ul>
                                        </div>
                                        <a href="{{route('getEdicionConjunto',[$conjunto->id_conjunto])}}" style="position: absolute;width: 100%;background: #DA8C10;color: white;text-align: center;border-bottom-right-radius: 3px;border-bottom-left-radius: 3px;">
                                            mas informacion <i class="fa fa-arrow-circle-right"></i>
                                        </a><br>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        </div>
                        <!-- /.box-body -->


                    </div>
                    <!-- (LISTADO CONJUNTOS) -->
                    <div class="chart tab-pane box {{$formCreacion}}" id="crearConjunto">
                        <div class="box-header">
                            <h3 class="box-title">Formulario de Creación</h3>
                        </div>

                        <div class="box-body">
                            @component('5_conjuntos.formularioCreacionConjunto')
                            @endcomponent
                        </div>
                    </div>
                    <!-- (CREACION DE CONJUNTO) -->
                </div>
            </div>
        </section>
    </div>
@endsection

@push('stylesheets')

@endpush

@push('scriptsPostLoad')
    <!-- InputMask -->
    <script src="{{asset('plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script src="{{asset('plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
    <script src="{{asset('plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>

    <script>
        Conjuntos = function(){};

        Conjuntos.prototype.eliminarConjunto = function(){
            $('.linkEliminarConjunto').click(function(event){
                event.preventDefault();
                url = $(this).attr('href');
                cc = $(this).data('cc');
                catalogo = $(this).data('catalogo');
                extensiones = $(this).data('extensiones');

                if(cc > 0){
                    swal("El conjunto tiene Canales de comincación relacionados", "imposbile eliminar!", "warning");
                    return null;
                }

                if(catalogo > 0){
                    swal("El conjunto tiene Catalogos relacionados", "imposbile eliminar!", "warning");
                    return null;
                }

                if(extensiones > 0){
                    swal("El conjunto tiene extensiones relacionados", "imposbile eliminar!", "warning");
                    return null;
                }

                swal({
                    title: "Está seguro de eliminar este conjunto?",
                    text: "por favor, confirme la eliminación",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).
                then((willDelete) => {
                    if (willDelete) {
                        window.location.href = url;
                    }
                });

            });
        };

        objConjuntos = new Conjuntos();

        $(function(){
            objConjuntos.eliminarConjunto();
        });
    </script>

    {{-- SCRIPT DE FORMULARIO CREACION CONJUNTO --}}
    @yield('scriptsCreacionConjunto')

@endpush

@endcomponent