@component('0_layouts.blank')
    @slot('activeUsuarios', 'active')

    @slot('menuPagina')
        <h1>
            USUARIOS
            <small>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i>{{trans('generales.inicio')}}</a></li>
            <li class="active">{{trans('usuario.usuario.usuarios')}}</li>
        </ol>
    @endslot

@section('contenidoPagina')
    <div class="row">

        <section class="col-lg-12 connectedSortable ui-sortable">
            <div class="nav-tabs-custom" style="cursor: move;">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right ui-sortable-handle">
                    <li class="{{$pestaniaForm}}"><a href="#crearUsuario" data-toggle="tab"><i class="fa fa-user-plus" aria-hidden="true"></i> {{trans('usuario.gestionusuarios.crear')}}</a></li>
                    <li class="{{$pestaniaLista}}"><a href="#listadoUsuarios" data-toggle="tab"><i class="fa fa-list" aria-hidden="true"></i>   {{trans('usuario.gestionusuarios.listado')}}</a></li>
                    <li class="pull-left header"><i class="fa fa-user-o" aria-hidden="true"></i></li>
                </ul>
                <div class="tab-content no-padding">

                    <div class="chart tab-pane box {{$divLista}}" id="listadoUsuarios" >
                            <div class="box-header">
                                <h3 class="box-title">{{trans('usuario.gestionusuarios.listado')}}</h3>

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
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tbody>
                                    <tr>
                                        <th>{{trans('usuario.gestionusuarios.id')}}</th>
                                        <th>{{trans('usuario.transversales.identificacion')}}</th>
                                        <th>{{trans('usuario.transversales.nombres')}}</th>
                                        <th>{{trans('usuario.transversales.apellidos')}}</th>
                                        <th>{{trans('usuario.transversales.correo')}}</th>
                                        <th>{{trans('usuario.gestionusuarios.editar')}}</th>
                                        <th>{{trans('usuario.gestionusuarios.eliminar')}}</th>
                                    </tr>
                                    @php $contador = 0 @endphp
                                    @foreach($usuarios->data as $usuario)
                                        @if($usuario->id_usuario != \Auth::user()->id_usuario)
                                            <tr>
                                                <td>{{$contador++}}</td>
                                                <td>{{$usuario->identificacion}}</td>
                                                <td>{{$usuario->nombres}}</td>
                                                <td>{{$usuario->apellidos}}</td>
                                                <td>{{$usuario->email}}</td>
                                                <td style="padding-left: 20px;"><a href="{{route('getUsuario', [$usuario->id_usuario])}}"><i class="fa fa-circle-o text-aqua" aria-hidden="true"></i></a></td>
                                                <td style="padding-left: 20px;"><a href="{{route('getUsuario', [$usuario->id_usuario])}}"><i class="fa fa-circle-o text-red" aria-hidden="true"></i></a></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                    </div>
                    <!--/.chart (LISTADO USUARIOS) -->
                    <div class="chart tab-pane box {{$divFormCreacion}}" id="crearUsuario">
                        <div class="box-header">
                            <h3 class="box-title">Formulario de Creación</h3>
                        </div>

                        <div class="box-body">
                            {{-- FORMULARIO --}}
                            @component ('0_partials.formularioUsuario')
                                @slot('rutaFormulario', route('postUsuario'))
                                @slot('datosUsuario', $datosUsuario)
                                @slot('btnFormulario')
                                    <button type="submit" class="btn btn-success pull-right">{{trans('usuario.gestionusuarios.btnconfirmarcreacion')}}</button>
                                @endslot
                            @endcomponent

                        </div>
                    </div>
                    <!--./chart (CREACION DE USUARIO) -->
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

        var FormUsuarios = function(){};

        /*
         * Define los vlrs para los campos Direccion y Telefono
         * Una vez se ha seleccionado un conjunto
         */
        FormUsuarios.prototype.selectConjunto = function(idConjunto){

            if(idConjunto === '0'){
                $('input[name="direccion"]').val('');
                $('input[name="telefono"]').val('');
                return null;
            }

            /*
             * Consulta de info conjunto por id
             */
            $.get('{{route('getConjunto', [null])}}/' + idConjunto, function(response){

                var response_1 = response;

                $('input[name="direccion"]').val(response_1.data.direccion);
                $('input[name="telefono"]').val(response_1.data.telefono);

            }).
            fail(function(){
                swal ( "Oops" ,  "Por favor, vuelva a intentarlo!" ,  "error" )
            });
        };

        $(function () {

            var objFormUsuario = new FormUsuarios();
            selectConjunto = $('select[name="idConjunto"]');

            $(selectConjunto).change(function(){
                objFormUsuario.selectConjunto($(this).val());
            });

            // Inicializar vlrs si viene por defecto el conjunto
            objFormUsuario.selectConjunto($(selectConjunto).val());

            //Money Euro
            $('[data-mask]').inputmask();

        });
    </script>
@endpush

@endcomponent