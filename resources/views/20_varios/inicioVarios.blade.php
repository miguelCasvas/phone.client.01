@component('0_layouts.blank')
    @slot('activeCatalogo', 'active')
    @slot('activeAdminCatalogo', 'active')

    @slot('menuPagina')
        <h1>
            PARAMETRIZACIONES
            <small>Configuraciones basicas</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Parametrizaciones</li>
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