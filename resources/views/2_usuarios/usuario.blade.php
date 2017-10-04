@component('0_layouts.blank')

    @slot('menuPagina')
        <h1>
            PERFIL <small>{{$datosUsuario->nombres}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="{{route('getListadoUsuarios')}}"><i class="fa fa-dashboard"></i> usuarios</a></li>
            <li class="active">Perfil usuario</li>
        </ol>
    @endslot

@section('contenidoPagina')

    <div class="row">
        {{-- DATOS GENERALES --}}
        <div class="col-xs-12">
            <div class="box box-primary">
                {{-- FORMULARIO --}}
                @component ('0_partials.formularioUsuario')
                    @slot('rutaFormulario', route('putUsuario', [$datosUsuario->id_usuario]))
                    @slot('datosUsuario', $datosUsuario)
                    @slot('nombreForm', 'formEdicionUsuario')
                    @slot('metodo', method_field('PUT'))
                    @slot('btnFormulario')
                        <button type="submit" class="btn btn-info pull-right">Actualizar</button>
                    @endslot
                @endcomponent
            </div>
        </div>

        <div class="col-xs-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <i class="fa fa-tag" aria-hidden="true"></i> <h3 class="box-title">Relación Extension<span class="text-muted">(es)</span></h3>
                </div>
                <div class="box-body row">
                    @foreach($datosUsuario->extensiones as $extension)
                        <div class="col-lg-4">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Extensión <span class="text-primary">{{$extension->extension}}</span></h3>

                                    <div class="box-tools">
                                        <button type="button" class="btn btn-box-tool" title="Eliminar Extensión {{$extension->extension}}"><i class="fa fa-trash-o text-danger"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body no-padding" style="">
                                    <ul class="nav nav-pills nav-stacked">
                                        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> Conjunto: <strong>{{ $extension->nombre_conjunto }}</strong></a></li>
                                        <li>Dirección: {{$extension->direccion}}</li>
                                        <li>Telefóno: {{$extension->telefono}}</li>
                                    </ul>
                                </div>
                                <!-- /.box-body -->
                            </div>
{{--                            {{dump($extension)}}--}}
                        </div>
                    @endforeach
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-default pull-right">Crear extensión</button>
                </div>
            </div>

        </div>

        <!--/.box (FORMULARIO EDICION USUARIO) -->
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Permisos</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>Permiso</th>
                            <th>Modulo</th>
                            <th style="width: 10px">#</th>
                        </tr>
                        @php
                            $contador = 0;
                        @endphp
                        @foreach($datosUsuario->permisos as $permiso)
                            <tr>
                                <td>{{$permiso->nombre_permiso}}</td>
                                <td>{{$permiso->nombre_modelo}}</td>
                                <td class="text-success"><i class="fa fa-check-circle-o" aria-hidden="true"></i></td>
                            </tr>
                            @php
                                $contador++;
                                //if ($contador == 10) break;
                            @endphp
                        @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <li><a href="#">«</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">»</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('stylesheets')

@endpush

@push('scriptsPostLoad')
    <!-- InputMask -->
    <script src="/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="/plugins/input-mask/jquery.inputmask.extensions.js"></script>
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

                /*
                 * Consulta de extensiones del conjunto seleccionado
                 */
                $.get('{{route('getExtensionesConjunto', [null])}}/' + response.data.id_conjunto, function(response){

                    var selectExtensiones = $('select[name="idExtension"]');
                    $(selectExtensiones).empty();


                    optionTag = $('<option>', {value: '', text: 'Selección'});
                    $(selectExtensiones).append(optionTag);

                    $(response.data).each(function(index, element){

                        statusDisabled = false;
                        textOption = element.extension;

                        if(element.usuarioAsignado !== null){
                            statusDisabled = true;
                            textOption += ' (Asignada)';
                        }

                        optionTag = $('<option>', {value: element.id_extension, text: textOption, disabled:statusDisabled});
                        $(selectExtensiones).append(optionTag);
                    });

                    $('input[name="direccion"]').val(response_1.data.direccion);
                    $('input[name="telefono"]').val(response_1.data.telefono);
                }).
                fail(function(){
                    swal ( "Oops" ,  "Por favor, vuelva a intentarlo!" ,  "error" );
                    return null;
                });

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