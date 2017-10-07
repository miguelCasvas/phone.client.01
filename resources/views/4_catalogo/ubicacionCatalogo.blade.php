@component('0_layouts.blank')
    @slot('activeCatalogo', 'active')
    @slot('activeAdminUbicacion', 'active')

    @slot('menuPagina')
        <h1>
            {{trans('catalogo.catalogo.ubicacioncatalogo')}}
            <small>.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('inicioUsuario')}}"><i class="fa fa-dashboard"></i> {{trans('generales.inicio')}}</a></li>
            <li class="active">{{trans('catalogo.catalogo.catalogos')}}</li>
            <li class="active">{{trans('catalogo.catalogo.ubicacioncatalogo2')}}</li>
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