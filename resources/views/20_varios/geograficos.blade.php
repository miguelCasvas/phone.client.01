<div class="box box-warning">
    <!-- /.box-body -->
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
            <div class="col-lg-4">
                <h4>Seleccione <small class="text-muted">(País / Departamento / Ciudad)</small></h4>
                {{Form::bsSelect('Paises', 'id_pais', $paises, null, [], false)}}
                {{Form::bsSelect('Departamentos', 'id_departamento', [], null, [], false)}}
                {{Form::bsSelect('Ciudades', 'id_ciudad', [], null, [], false)}}

            </div>
            <div class="col-lg-4 col-lg-offset-1">
                <h4>Edición</h4>
                {{ Form::bsTextIcon(
                        'Pais',
                        'id_pais',
                        '',
                        [],
                        'fa-pencil',
                        true
                    )
                 }}

                {{ Form::bsTextIcon(
                        'Departamento',
                        'id_departamento',
                        '',
                        [],
                        'fa-pencil',
                        false
                    )
                 }}

                {{ Form::bsTextIcon(
                        'Ciudad',
                        'id_ciudad',
                        '',
                        [],
                        'fa-pencil',
                        false
                    )
                 }}
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right">{{trans('usuario.transversales.btncrearextension')}}</button>
        </div>
    </form>
    <!-- /.box-footer-->
</div>