@component('0_layouts.blank')
    @slot('activeCC', 'active')

    @slot('menuPagina')
        <h1>
            CANALES DE COMUNICACIÓN
            <small>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Canales Comunicación</li>
        </ol>
    @endslot

    @section('contenidoPagina')
        <div class="box">
            <div class="box-header with-border">
                <h3></h3>
                <div class="box-tools">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm" title="Eliminar Canal" id="btnEliminarCanales"><i class="fa fa-trash-o"></i></button>
                        <button type="button" class="btn btn-default btn-sm" title="Agregar Canal" id="btnCrearCanal"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form action="{{route('getEliminacionCC')}}">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="info">
                                <th>Conjunto</th>
                                <th style="width: 250px">Canal</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($arregloCanales as $elemento)
                        <tr><td rowspan="{{count($elemento['canales']) + 1}}"><strong><u>{{$elemento['conjunto']}}</u></strong></td></tr>
                        @foreach($elemento['canales'] as $_elemento)
                        <tr class="info">
                            <td>
                                <small><i class="fa  fa-check"></i></small> {{$_elemento['canal']}}
                                <label class="pull-right text-danger">
                                    <input type="checkbox" name="conjunto[{{$_elemento['id_conjunto']}}]" value="{{$_elemento['id_canal']}}">
                                    <i class="fa fa-trash-o"></i>
                                </label>
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">

            </div>
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

            var FormularioCC = function(){

            };

            FormularioCC.prototype.eliminacionCanales = function(){
                swal({
                    title: "Está seguro?",
                    text: "Por favor, confirme la eliminación de los Canales!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).
                then((willDelete) => {
                    if (willDelete) {
                        swal("Poof! Your imaginary file has been deleted!", {
                            icon: "success",
                        });
                    }
                });
            };

            var objFormCC = new FormularioCC();

            $(document).ready(function(){

                $('#btnEliminarCanales').click(function(){
                    objFormCC.eliminacionCanales();
                });

            });

        </script>

    @endpush

@endcomponent