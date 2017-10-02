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

            $.get('{{route('getConjunto', [null])}}/' + idConjunto, function(response){
                $('input[name="direccion"]').val(response.data.direccion);
                $('input[name="telefono"]').val(response.data.telefono);
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