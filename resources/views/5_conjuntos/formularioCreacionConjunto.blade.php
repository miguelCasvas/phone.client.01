<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
    </div>
    <!-- FORMULARIO DE EDICION CONJUNTO -->
    <form role="form" name="formCreacionConjunto" method="post" action="{{route('postCreacionConjunto')}}">

        {{ csrf_field() }}

        <div class="box-body">
            <div class="row">
                <div class="col-lg-4 col-lg-offset-6" style="text-align: right">
                    <span class="text-muted" style="margin-right: 5px;">Limpiar Geograficos</span>
                    <a href="#" id="linkLimpiarForm"><i class="fa fa-refresh"></i></a>
                </div>

                <div class="col-lg-4 col-lg-offset-2">
                    {{-- NOMBRE CONJUNTO --}}
                    {{ Form::bsText('Nombre Conjunto', 'nombreConjunto', old('nombreConjunto'), [], true) }}

                    {{-- DIRECCIÓN --}}
                    {{ Form::bsText('Dirección', 'direccion', old('direccion'), [], true) }}

                    {{-- CORREO --}}
                    {{ Form::bsTextIcon(
                            'Correo',
                            'correo',
                            old('correo'),
                            [],
                            'fa-envelope-o',
                            true
                        )
                     }}

                    {{-- TELEFONO --}}
                    {{ Form::bsTextIcon(
                            'Telefono',
                            'telefono',
                            '',
                            [],
                            'fa-volume-control-phone',
                            true
                        )
                     }}
                </div>
                <div class="col-lg-4">
                    {{Form::bsSelect('Paises', 'selectPais', $paises, null, [], false)}}
                    {{Form::bsSelect('Departamentos', 'selectDepartamento', $departamentos, null, [], false)}}
                    {{Form::bsSelect('Ciudad', 'idCiudad', $ciudades, null, [], true)}}
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right">Crear</button>
        </div>
    </form>
</div>

@section('scriptsCreacionConjunto')
    <script>

        var CreacionConjunto = function(){

            this.forMaestro = $('form[name="formCreacionConjunto"]');
            this.pais = $('select[name="selectPais"]');
            this.departamento = $('select[name="selectDepartamento"]');
            this.ciudad = $('select[name="idCiudad"]');

        };

        CreacionConjunto.prototype.cambioPais = function(){

            $(this.pais).change(function(){
                url = '{{route('getFiltradoDepartamentos')}}';
                params = {id_pais: $(this).val()};

                objCreacionConjunto.llenarDepartamentos(null);
                objCreacionConjunto.llenarCiudades(null);

                if($(this).val() > 0){
                    $(objCreacionConjunto.idPais).val($(this).val());
                    $(objCreacionConjunto.nomPais).val($(this).find('option:selected').text());
                    objCreacionConjunto.asincrono(url, params, objCreacionConjunto.llenarDepartamentos);
                }
                else{
                    $(objCreacionConjunto.idPais).val('');
                    $(objCreacionConjunto.nomPais).val('');
                }
            });

        };

        CreacionConjunto.prototype.cambioDepartamento = function(){

            $(this.departamento).change(function(){
                url = '{{route('getFiltradoCiudades')}}';
                params = {id_departamento: $(this).val()}

                objCreacionConjunto.llenarCiudades(null);
                objCreacionConjunto.asincrono(url, params, objCreacionConjunto.llenarCiudades);
            });

        };

        CreacionConjunto.prototype.llenarDepartamentos = function(departamentos){

            $(objCreacionConjunto.departamento).html('');
            $(objCreacionConjunto.departamento).append('<option value="">Selección</option>');

            if (departamentos !== null){
                $.each(departamentos.data, function(id, departamento){
                    option = '<option value='+departamento.id_departamento+'>'+departamento.nombre_departamento+'</option>';
                    $(objCreacionConjunto.departamento).append(option);
                });
            }

        };

        CreacionConjunto.prototype.llenarCiudades = function(ciudades){

            $(objCreacionConjunto.ciudad).html('');
            $(objCreacionConjunto.ciudad).append('<option value="">Selección</option>');

            if(ciudades !== null){
                $.each(ciudades.data, function(id, ciudad){
                    option = '<option value='+ciudad.id_ciudad+'>'+ciudad.nombre_ciudad+'</option>';
                    $(objCreacionConjunto.ciudad).append(option);
                });
            }
        };

        CreacionConjunto.prototype.asincrono = function(url, params, callback){

            $.get(url, params, callback);
        };

        CreacionConjunto.prototype.linkLimpiarForm = function(){

            $('#linkLimpiarForm').click(function(){
                $(objCreacionConjunto.pais).val(0);
                objCreacionConjunto.llenarDepartamentos(null);
                objCreacionConjunto.llenarCiudades(null);
            });
        };


        var objCreacionConjunto = new CreacionConjunto();

        $(function(){
            objCreacionConjunto.cambioPais();
            objCreacionConjunto.cambioDepartamento();
            objCreacionConjunto.linkLimpiarForm();

        });

    </script>
@endsection
