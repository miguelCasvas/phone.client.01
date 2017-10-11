@component('0_layouts.blank')
    @slot('activeConjuntos', 'active')

    @slot('menuPagina')
        <h1>
            Conjunto {{$conjunto->nombre_conjunto}}
            <small>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i>{{trans('generales.inicio')}}</a></li>
            <li><a href="{{route('getInicioConjuntos')}}"><i class="fa fa-dashboard"></i>Conjuntos</a></li>
            <li class="active">Edición Conjunto</li>
        </ol>
    @endslot

    @section('contenidoPagina')
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>
            </div>
            <!-- FORMULARIO DE EDICION CONJUNTO -->
            <form role="form" name="formEdicionConjunto" method="post" action="{{route('postEdicionConjunto', [$conjunto->id_conjunto])}}">

                {{ csrf_field() }}

                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-6" style="text-align: right">
                            <span class="text-muted" style="margin-right: 5px;">Limpiar Geograficos</span>
                            <a href="#" id="linkLimpiarForm"><i class="fa fa-refresh"></i></a>
                        </div>

                        <div class="col-lg-4 col-lg-offset-2">
                            {{-- NOMBRE CONJUNTO --}}
                            {{ Form::bsText('Nombre Conjunto', 'nombreConjunto', $conjunto->nombre_conjunto, [], true) }}

                            {{-- DIRECCIÓN --}}
                            {{ Form::bsText('Dirección', 'direccion', $conjunto->direccion, [], true) }}

                            {{-- CORREO --}}
                            {{ Form::bsTextIcon(
                                    'Correo',
                                    'correo',
                                    $conjunto->email,
                                    [],
                                    'fa-envelope-o',
                                    true
                                )
                             }}

                            {{-- TELEFONO --}}
                            {{ Form::bsTextIcon(
                                    'Telefono',
                                    'telefono',
                                    $conjunto->telefono,
                                    [],
                                    'fa-volume-control-phone',
                                    true
                                )
                             }}
                        </div>
                        <div class="col-lg-4">
                            {{Form::bsSelect('Paises', 'selectPais', $paises, $idPais, [], false)}}
                            {{Form::bsSelect('Departamentos', 'selectDepartamento', $departamentos, $idDepartamento, [], false)}}
                            {{Form::bsSelect('Ciudad', 'idCiudad', $ciudades, $conjunto->id_ciudad, [], true)}}
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right">Modificar</button>
                </div>
            </form>
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
            var EdicionConjunto = function(){

                this.forMaestro = $('form[name="formEdicionConjunto"]');
                this.pais = $('select[name="selectPais"]');
                this.departamento = $('select[name="selectDepartamento"]');
                this.ciudad = $('select[name="idCiudad"]');

            };

            EdicionConjunto.prototype.cambioPais = function(){

                $(this.pais).change(function(){
                    url = '{{route('getFiltradoDepartamentos')}}';
                    params = {id_pais: $(this).val()};

                    objEdicionConjunto.llenarDepartamentos(null);
                    objEdicionConjunto.llenarCiudades(null);

                    if($(this).val() > 0){
                        $(objEdicionConjunto.idPais).val($(this).val());
                        $(objEdicionConjunto.nomPais).val($(this).find('option:selected').text());
                        objEdicionConjunto.asincrono(url, params, objEdicionConjunto.llenarDepartamentos);
                    }
                    else{
                        $(objEdicionConjunto.idPais).val('');
                        $(objEdicionConjunto.nomPais).val('');
                    }
                });

            };

            EdicionConjunto.prototype.cambioDepartamento = function(){

                $(this.departamento).change(function(){
                    url = '{{route('getFiltradoCiudades')}}';
                    params = {id_departamento: $(this).val()}

                    objEdicionConjunto.llenarCiudades(null);
                    objEdicionConjunto.asincrono(url, params, objEdicionConjunto.llenarCiudades);
                });

            };

            EdicionConjunto.prototype.llenarDepartamentos = function(departamentos){

                $(objEdicionConjunto.departamento).html('');
                $(objEdicionConjunto.departamento).append('<option value="">Selección</option>');

                if (departamentos !== null){
                    $.each(departamentos.data, function(id, departamento){
                        option = '<option value='+departamento.id_departamento+'>'+departamento.nombre_departamento+'</option>';
                        $(objEdicionConjunto.departamento).append(option);
                    });
                }

            };

            EdicionConjunto.prototype.llenarCiudades = function(ciudades){

                $(objEdicionConjunto.ciudad).html('');
                $(objEdicionConjunto.ciudad).append('<option value="">Selección</option>');

                if(ciudades !== null){
                    $.each(ciudades.data, function(id, ciudad){
                        option = '<option value='+ciudad.id_ciudad+'>'+ciudad.nombre_ciudad+'</option>';
                        $(objEdicionConjunto.ciudad).append(option);
                    });
                }
            };

            EdicionConjunto.prototype.asincrono = function(url, params, callback){

                $.get(url, params, callback);
            };

            EdicionConjunto.prototype.linkLimpiarForm = function(){

                $('#linkLimpiarForm').click(function(){
                    $(objEdicionConjunto.pais).val(0);
                    objEdicionConjunto.llenarDepartamentos(null);
                    objEdicionConjunto.llenarCiudades(null);
                });
            };


            var objEdicionConjunto = new EdicionConjunto();

            $(function(){
                objEdicionConjunto.cambioPais();
                objEdicionConjunto.cambioDepartamento();
                objEdicionConjunto.linkLimpiarForm();

            });

        </script>
    @endpush

@endcomponent