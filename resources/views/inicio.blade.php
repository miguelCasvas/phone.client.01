@component('0_layouts.blank')
    @slot('menuPagina')
        <h1>
            PHONE UP
            <small>Version 1.0</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        </ol>
    @endslot

    @section('contenidoPagina')

    @endsection

    @push('scriptsPostLoad')

    @endpush

@endcomponent