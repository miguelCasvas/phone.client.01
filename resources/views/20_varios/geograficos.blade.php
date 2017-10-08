<!-- /.box-body -->
<div class="box box-warning">
    <form action="" method="post" class="form">
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

                {{Form::bsSelect('Paises', 'SelectPais', $paises, null, [], false)}}
                {{Form::bsSelect('Departamentos', 'selectDepartamento', [], null, [], false)}}
                {{Form::bsSelect('Ciudades', 'selectCiudad', [], null, [], false)}}

            </div>

            <!-- (EDICION / ELIMINACION) -->
            <div class="col-lg-4">
                <h4>Gestión</h4>

                <!-- GESTION DE PAIS -->
                <div class="input-group" >
                    <label for=""><small><i class="fa fa-asterisk" aria-hidden="true"></i></small> País</label>
                    <input type="hidden" name="idPais" value="">
                    <input type="hidden" name="nombreOficialPais" value="">
                    <input name="nombrePais" class="form-control">

                    <div class="input-group-btn" style="top: 13px">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acción
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span> </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Editar</a></li>
                            <li><a href="#"><i class="fa fa-trash-o" aria-hidden="true"></i>Eliminar</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#"><i class="fa fa-plus-circle" aria-hidden="true"></i>Crear</a></li></ul>
                    </div>
                </div>

                <!-- GESTION DE DEPARTAMENTO -->
                <div class="input-group" style="top: 15px;">
                    <label for=""><small><i class="fa fa-asterisk" aria-hidden="true"></i></small> Departamento</label>
                    <input type="hidden" name="idDepartamento" value="">
                    <input name="nombreDepartamento" class="form-control">

                    <div class="input-group-btn" style="top: 13px">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acción
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span> </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Editar</a></li>
                            <li><a href="#"><i class="fa fa-trash-o" aria-hidden="true"></i>Eliminar</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#"><i class="fa fa-plus-circle" aria-hidden="true"></i>Crear</a></li></ul>
                    </div>
                </div>

                <!-- GESTION DE CIUDAD -->
                <div class="input-group" style="top: 30px; margin-bottom: 40px;">
                    <label for=""><small><i class="fa fa-asterisk" aria-hidden="true"></i></small>Ciudad</label>
                    <input type="hidden" name="idCiudad" value="">
                    <input name="nombreCiudad" class="form-control">

                    <div class="input-group-btn" style="top: 13px">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Acción
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span> </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Editar</a></li>
                            <li><a href="#"><i class="fa fa-trash-o" aria-hidden="true"></i>Eliminar</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#"><i class="fa fa-plus-circle" aria-hidden="true"></i>Crear</a></li></ul>
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>

@section('scriptsGeograficos')
    <script>
        var Geograficos = function(){

            this.pais = $('select[name="SelectPais"]');
            this.idPais = $('input[name="idPais"]');
            this.nomPais = $('input[name="nombrePais"]');

            this.departamento = $('select[name="selectDepartamento"]');
            this.idDep = $('input[name="idDepartamento"]');
            this.nomDep = $('input[name="idDepartamento"]');

            this.ciudad = $('select[name="selectCiudad"]');
            this.idCiudad = $('input[name="idCiudad"]');
            this.nomCiudad = $('input[name="nombreCiudad"]');

        };

        Geograficos.prototype.cambioPais = function(){
            $(this.pais).change(function(){
                url = '{{route('getFiltradoDepartamentos')}}';
                params = {id_pais: $(this).val()}
                objGeograficos.asincrono(url, params, objGeograficos.llenarDepartamentos);
            });
        };

        Geograficos.prototype.llenarDepartamentos = function(departamentos){

            $(objGeograficos.departamento).html('');
            $(objGeograficos.ciudad).html('');
            $(objGeograficos.departamento).append('<option value="">Selección</option>');

            $.each(departamentos.data, function(id, departamento){
                option = '<option value='+departamento.id_departamento+'>'+departamento.nombre_departamento+'</option>';
                $(objGeograficos.departamento).append(option);
            });
        };

        Geograficos.prototype.asincrono = function(url, params, callback){

            $.get(url, params, callback);
        };

        var objGeograficos = new Geograficos();

        $(function(){
            objGeograficos.cambioPais();
        });

    </script>
@endsection