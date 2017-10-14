@component('0_layouts.blank')
    @slot('menuPagina')
        <h1>
            {{trans('configbasica.varios.parametrizaciones')}}
            <small>{{trans('configbasica.varios.configbasicas')}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i> {{trans('generales.inicio')}}</a></li>
            <li class="active">{{trans('configbasica.varios.parametrizaciones2')}}</li>
        </ol>
    @endslot

    @section('contenidoPagina')
        <div class="row">

            <div class="col-lg-12">
                @component('20_varios.geograficos')

                @endcomponent
            </div>
        </div>
    @endsection

    @push('stylesheets')
    @endpush

    @push('scriptsPostLoad')
        @yield('scriptsGeograficos')
    @endpush

@endcomponent