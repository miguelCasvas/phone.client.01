@component('0_layouts.blank')
    @slot('activeCatalogo', 'active')
    @slot('activeAdminUbicacion', 'active')

    @slot('menuPagina')
        <h1>
            UBICACION CATALOGOS
            <small>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Catalogos</li>
            <li class="active">Ubicación Catalogos</li>
        </ol>
    @endslot

@section('contenidoPagina')
    HOLA MUNDO
@endsection

@push('stylesheets')

@endpush

@push('scriptsPostLoad')
    <!-- InputMask -->
    <script src="{{asset('plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script src="{{asset('plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
    <script src="{{asset('plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
    <script>
    </script>
@endpush

@endcomponent