@component('0_layouts.blank')

    @slot('menuPagina')
        <h1>PERFIL <small>{{$datosUsuario->nombres}}</small></h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Mi Perfil</li>
        </ol>
    @endslot

    @section('contenidoPagina')
        <div class="row">
            {{-- INCLUSION DE FORMUULARIO USUARIO --}}

            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-tag" aria-hidden="true"></i> <h3 class="box-title">Información general</h3>
                    </div>
                    <!-- /.box-header -->

                    {{-- FORMULARIO --}}
                    @component ('0_partials.formularioUsuario')
                        @slot('rutaFormulario', route('putMiPerfil', [$datosUsuario->id_usuario]))
                        @slot('metodo', method_field('PUT'))
                        @slot('datosUsuario', $datosUsuario)
                        @slot('btnFormulario')
                            <button type="submit" class="btn btn-info pull-right">Actualizar</button>
                        @endslot
                    @endcomponent

                </div>
            </div>

            <div class="col-xs-12 col-md-6">
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
        <script src="plugins/input-mask/jquery.inputmask.js"></script>
        <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
        <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
        <script>
            $(function () {

                //Money Euro
                $('[data-mask]').inputmask()
            })

        </script>
    @endpush
@endcomponent