<!-- /.box-body -->
<div class="box box-warning">
    <form action="" method="post" class="form" name="formGeografico">
        {{ csrf_field() }}
        <div class="box-header with-border">
            <h3 class="box-title">Geograficos</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="col-lg-4 col-lg-offset-2">
                <h4>Seleccione <small class="text-muted">(País / Departamento / Ciudad)</small></h4>

                {{Form::bsSelect('Paises', 'selectPais', $paises, null, [], false)}}
                {{Form::bsSelect('Departamentos', 'selectDepartamento', $departamentos, null, [], false)}}
                {{Form::bsSelect('Ciudades', 'selectCiudad', $ciudades, null, [], false)}}

            </div>

            <!-- (EDICION / ELIMINACION) -->
            <div class="col-lg-4">
                <h4>Gestión <a href="#" id="linkLimpiarForm" class="pull-right" title="Limpiar formulario"><i class="fa fa-refresh"></i></a></h4>

                <!-- GESTION DE PAIS -->
                <div class="input-group" >
                    <label for=""><small><i class="fa fa-asterisk" aria-hidden="true"></i></small> País</label>
                    <input type="hidden" name="idPais" value="{{old('idPais')}}">
                    <input name="nombrePais" class="form-control" value="{{old('nombrePais')}}">

                    <div class="input-group-btn" style="top: 13px">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acción
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span> </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="#" id="linkEditPais"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Editar</a></li>
                            <li><a href="#" id="linkElimPais"><i class="fa fa-trash-o" aria-hidden="true"></i>Eliminar</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" id="linkCrearPais"><i class="fa fa-plus-circle" aria-hidden="true"></i>Crear</a></li></ul>
                    </div>
                </div>

                <!-- GESTION DE DEPARTAMENTO -->
                <div class="input-group" style="top: 15px;">
                    <label for=""><small><i class="fa fa-asterisk" aria-hidden="true"></i></small> Departamento</label>
                    <input type="hidden" name="idDepartamento" value="{{old('idDepartamento')}}">
                    <input name="nombreDepartamento" class="form-control" value="{{old('nombreDepartamento')}}">

                    <div class="input-group-btn" style="top: 13px">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acción
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span> </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="#" id="linkEditDep"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Editar</a></li>
                            <li><a href="#" id="linkElimDep"><i class="fa fa-trash-o" aria-hidden="true"></i>Eliminar</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" id="linkCrearDep"><i class="fa fa-plus-circle" aria-hidden="true"></i>Crear</a></li></ul>
                    </div>
                </div>

                <!-- GESTION DE CIUDAD -->
                <div class="input-group" style="top: 30px; margin-bottom: 40px;">
                    <label for=""><small><i class="fa fa-asterisk" aria-hidden="true"></i></small>Ciudad</label>
                    <input type="hidden" name="idCiudad" value="{{old('idCiudad')}}">
                    <input name="nombreCiudad" class="form-control" value="{{old('')}}">

                    <div class="input-group-btn" style="top: 13px">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acción
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span> </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="#" id="linkEditCiudad"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Editar</a></li>
                            <li><a href="#" id="linkElimCiudad"><i class="fa fa-trash-o" aria-hidden="true"></i>Eliminar</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" id="linkCrearCiudad"><i class="fa fa-plus-circle" aria-hidden="true"></i>Crear</a></li></ul>
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>

@section('scriptsGeograficos')
    <script>
        var Geograficos = function(){

            this.forMaestro = $('form[name="formGeografico"]');

            this.pais = $('select[name="selectPais"]');
            this.idPais = $('input[name="idPais"]');
            this.nomPais = $('input[name="nombrePais"]');

            this.departamento = $('select[name="selectDepartamento"]');
            this.idDep = $('input[name="idDepartamento"]');
            this.nomDep = $('input[name="nombreDepartamento"]');

            this.ciudad = $('select[name="selectCiudad"]');
            this.idCiudad = $('input[name="idCiudad"]');
            this.nomCiudad = $('input[name="nombreCiudad"]');

        };

        Geograficos.prototype.cambioPais = function(){

            $(this.pais).change(function(){
                url = '{{route('getFiltradoDepartamentos')}}';
                params = {id_pais: $(this).val()};

                objGeograficos.llenarDepartamentos(null);
                objGeograficos.llenarCiudades(null);

                if($(this).val() > 0){
                    $(objGeograficos.idPais).val($(this).val());
                    $(objGeograficos.nomPais).val($(this).find('option:selected').text());
                    objGeograficos.asincrono(url, params, objGeograficos.llenarDepartamentos);
                }
                else{
                    $(objGeograficos.idPais).val('');
                    $(objGeograficos.nomPais).val('');
                }
            });

        };

        Geograficos.prototype.cambioDepartamento = function(){

            $(this.departamento).change(function(){
                url = '{{route('getFiltradoCiudades')}}';
                params = {id_departamento: $(this).val()}

                objGeograficos.llenarCiudades(null);

                if($(this).val() !== ''){
                    $(objGeograficos.idDep).val($(this).val());
                    $(objGeograficos.nomDep).val($(this).find('option:selected').text());
                }

                objGeograficos.asincrono(url, params, objGeograficos.llenarCiudades);
            });

        };

        Geograficos.prototype.cambioCiudad = function(){

            $(this.ciudad).change(function(){
                if($(this).val() !== ''){
                    $(objGeograficos.idCiudad).val($(this).val());
                    $(objGeograficos.nomCiudad).val($(this).find('option:selected').text());
                }
                else{
                    $(objGeograficos.idCiudad).val('');
                    $(objGeograficos.nomCiudad).val('');
                }
            });
        };

        Geograficos.prototype.llenarDepartamentos = function(departamentos){

            $(objGeograficos.departamento).html('');
            $(objGeograficos.departamento).append('<option value="">Selección</option>');

            $(objGeograficos.idDep).val('');
            $(objGeograficos.nomDep).val('');

            if (departamentos !== null){
                $.each(departamentos.data, function(id, departamento){
                    option = '<option value='+departamento.id_departamento+'>'+departamento.nombre_departamento+'</option>';
                    $(objGeograficos.departamento).append(option);
                });
            }

        };

        Geograficos.prototype.llenarCiudades = function(ciudades){

            $(objGeograficos.ciudad).html('');
            $(objGeograficos.ciudad).append('<option value="">Selección</option>');

            $(objGeograficos.idCiudad).val('');
            $(objGeograficos.nomCiudad).val('');

            if(ciudades !== null){
                $.each(ciudades.data, function(id, ciudad){
                    option = '<option value='+ciudad.id_ciudad+'>'+ciudad.nombre_ciudad+'</option>';
                    $(objGeograficos.ciudad).append(option);
                });
            }
        };

        Geograficos.prototype.asincrono = function(url, params, callback){

            $.get(url, params, callback);
        };

        Geograficos.prototype.linkLimpiarForm = function(){

            $('#linkLimpiarForm').click(function(){

                $(objGeograficos.pais).val(0);
                $(objGeograficos.idPais).val('');
                $(objGeograficos.nomPais).val('');

                objGeograficos.llenarDepartamentos(null);
                objGeograficos.llenarCiudades(null);
            });
        };

        /*
        * ACCIONES POR DEFECTO A BOTONES DE FORMULARIO PAIS
        * */
        Geograficos.prototype.editarPais = function(){
            $('#linkEditPais').click(function(){

                idPais = $(objGeograficos.idPais).val();

                if(objGeograficos.validarCampoRequerido(idPais, 'Seleccione páis a modificar'))
                    objGeograficos.enviarFormulario('{{route('putPais', [''])}}/' + idPais);

            });
        };

        Geograficos.prototype.eliminarPais = function(){
            $('#linkElimPais').click(function(){
                idPais = $(objGeograficos.idPais).val();

                if(objGeograficos.validarCampoRequerido(idPais, 'Seleccione páis a eliminar'))
                    objGeograficos.enviarFormulario('{{route('delPais', [''])}}/' + idPais);
            });
        };

        Geograficos.prototype.crearPais = function(){

            $('#linkCrearPais').click(function(){
                nomPais = $(objGeograficos.nomPais).val();

                if(objGeograficos.validarCampoRequerido(nomPais, 'Ingrese un país valido a crear'))
                    objGeograficos.enviarFormulario('{{route('postPais')}}');

            });

        };

        /*
        * ACCIONES POR DEFECTO A BOTONES DE FORMULARIO DEPARTAMENTO
        * */
        Geograficos.prototype.editarDepartamento = function(){
            $('#linkEditDep').click(function(){

                idPais = $(objGeograficos.idPais).val();
                if(objGeograficos.validarCampoRequerido(idPais, 'Seleccione un país para modificar un depto.')){

                    idDep = $(objGeograficos.idDep).val();
                    if(objGeograficos.validarCampoRequerido(idDep, 'Seleccione un depto a modificar.')){
                        objGeograficos.enviarFormulario('{{route('putDepartamento', [''])}}/' + idDep);
                    }
                }
            });
        };

        Geograficos.prototype.eliminarDepartamento = function(){
            $('#linkElimDep').click(function(){

                idPais = $(objGeograficos.idPais).val();
                if(objGeograficos.validarCampoRequerido(idPais, 'Seleccione un país para eliminar un depto.')){
                    idDep = $(objGeograficos.idDep).val();
                    if(objGeograficos.validarCampoRequerido(idDep, 'Seleccione un depto. para su eliminación.')){
                        objGeograficos.enviarFormulario('{{route('delDepartamento', [''])}}/' + idDep);
                    }
                }
            });
        };

        Geograficos.prototype.crearDepartamento = function(){
            $('#linkCrearDep').click(function(){

                idPais = $(objGeograficos.idPais).val();
                if(objGeograficos.validarCampoRequerido(idPais, 'Seleccione un país para crear el depto.')){
                    nomDep = $(objGeograficos.nomDep).val();
                    if(objGeograficos.validarCampoRequerido(nomDep, 'Ingrese un depto. valido para su creación')){
                        objGeograficos.enviarFormulario('{{route('postDepartamento')}}');
                    }
                }
            });
        };

        /*
        * ACCIONES POR DEFECTO A BOTONES DE FORMULARIO CIUDAD
        * */
        Geograficos.prototype.editarCiudad = function(){
            $('#linkEditCiudad').click(function(){

                idPais = $(objGeograficos.idPais).val();
                if(objGeograficos.validarCampoRequerido(idPais, 'Seleccione un país para modificar una ciudad')){

                    idDep = $(objGeograficos.idDep).val();
                    if(objGeograficos.validarCampoRequerido(idDep, 'Seleccione un depto. para modificar una ciudad')){

                        idCiudad = $(objGeograficos.idCiudad).val();
                        if(objGeograficos.validarCampoRequerido(idCiudad, 'Seleccione una ciudad para su modificación')) {
                            objGeograficos.enviarFormulario('{{route('putCiudad', [''])}}/' + idCiudad);
                        }
                    }
                }
            });
        };

        Geograficos.prototype.eliminarCiudad = function(){
            $('#linkElimCiudad').click(function(){

                idPais = $(objGeograficos.idPais).val();
                if(objGeograficos.validarCampoRequerido(idPais, 'Seleccione un país para eliminar una ciudad')){

                    idDep = $(objGeograficos.idDep).val();
                    if(objGeograficos.validarCampoRequerido(idDep, 'Seleccione un depto. para eliminar una ciudad')){

                        idCiudad = $(objGeograficos.idCiudad).val();
                        if(objGeograficos.validarCampoRequerido(idCiudad, 'Seleccione una ciudad para su eliminación')){
                            objGeograficos.enviarFormulario('{{route('delCiudad', [''])}}/' + idCiudad);
                        }
                    }
                }
            });
        };

        Geograficos.prototype.crearCiudad = function(){
            $('#linkCrearCiudad').click(function(){

                idPais = $(objGeograficos.idPais).val();
                if(objGeograficos.validarCampoRequerido(idPais, 'Seleccione un país para crear una ciudad')){

                    idDep = $(objGeograficos.idDep).val();
                    if(objGeograficos.validarCampoRequerido(idDep, 'Seleccione un depto. para crear una ciudad')){

                        nomCiudad = $(objGeograficos.nomCiudad).val();
                        if(objGeograficos.validarCampoRequerido(nomCiudad, 'Ingrese una ciudad valida para su creación')) {
                            objGeograficos.enviarFormulario('{{route('postCiudad')}}');
                        }
                    }
                }
            });
        };

        Geograficos.prototype.validarCampoRequerido = function(campo, msg){
            if(campo === null || campo === '' || campo === undefined){
                swal({
                    icon: "error",
                    title: msg
                });

                return false;
            }

            return true;
        };

        Geograficos.prototype.enviarFormulario = function(url){
            $(objGeograficos.forMaestro)
                .attr('action', url)
                .submit();
        };

        var objGeograficos = new Geograficos();

        $(function(){
            objGeograficos.cambioPais();
            objGeograficos.cambioDepartamento();
            objGeograficos.cambioCiudad();
            objGeograficos.linkLimpiarForm();

            /*
            * ASIGNACION DE FUNCIONALIDAD BOTONES (PAIS | DEPARTAMENTO | CIUDAD)
            * */
            objGeograficos.editarPais();
            objGeograficos.eliminarPais();
            objGeograficos.crearPais();

            objGeograficos.editarDepartamento();
            objGeograficos.eliminarDepartamento();
            objGeograficos.crearDepartamento();

            objGeograficos.editarCiudad();
            objGeograficos.eliminarCiudad();
            objGeograficos.crearCiudad();

        });

    </script>
@endsection