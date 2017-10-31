<form action="{{route('putUsuarioPW', [$idUsuario])}}" method="post">
    {!! method_field('PUT') !!}
    {{ csrf_field() }}
    @component('0_partials.defaultModal')
        @slot('idModalDef', 'ModalPW')
        @slot('typeButton', 'submit')
        @slot('titleModalDef', '<i class="fa fa-key" aria-hidden="true"></i> ' . trans('usuario.transversales.tituloPW', ['usuario' => $nomUsuario]))

        {{-- CONTRASEÑA --}}
        {{ Form::bsPassword(trans('usuario.transversales.contraseña'), 'contrasenia', [ 'placeholder'=> '*******'], true) }}

        {{-- CONTRASEÑA --}}
        {{ Form::bsPassword(trans('usuario.transversales.confirmacioncontraseña'), 'contrasenia_confirmation', [ 'placeholder'=> '*******'], true) }}

    @endcomponent
</form>

@section('scriptPW')
    <script>

        var CambioPW = function(){};

        @if($errors->first('contrasenia'))
            $('#ModalPW').modal();
        @endif

    </script>
@endsection