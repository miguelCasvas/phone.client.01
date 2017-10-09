@component('0_layouts.blank')

    @slot('menuPagina', '')


    @section('contenidoPagina')
        <div class="box box-warning">

            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
              <div class="col-md-5 col-xs-12"><img class="img-responsive" src="{{asset('img/enconstruccion.png')}}"></div>
                  <div class="col-md-7"> 
                        <h1 class="text-warning"><i class="fa fa-exclamation" aria-hidden="true"></i> {{trans('generales.enconstruccion')}}</h1>
                        <div style="font-size: 25px;">
                            <p>{{trans('generales.titulo')}}</p>
                            <p><strong>{{trans('generales.texto')}}</strong></p>
                        </div>

                  </div>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
            </div>
            <!-- /.box-footer -->
          </div>
    @endsection

    @push('stylesheets')

    @endpush

    @push('scriptsPostLoad')
        
    @endpush
@endcomponent