<form action="{{route('postUsuarioExten', [$idUsuario])}}" method="post">
    {{ csrf_field() }}
    @component('0_partials.defaultModal')
        @slot('idModalDef', 'ModalExten')
        @slot('typeButton', 'submit')
        @slot('titleModalDef', '<i class="fa fa-cog" aria-hidden="true"></i> ' . trans('usuario.transversales.tituloRelExten', ['usuario' => $nomUsuario]))

        {{Form::bsSelect('Extensiones', 'idExtension', [], [], [], true)}}

    @endcomponent
</form>

@section('scriptRelExten')
    <script>

        var RelExtesion = function(){

        };

        RelExtesion.prototype.busquedaExten = function(idConjunto){

            /*
             * Consulta de extensiones del conjunto seleccionado
             * idConjunto ==> variable global
             */
            ruta = '{{route('getExtensionesConjunto', ['%idConjunto%'])}}';
            rutaFinal = ruta.replace('%idConjunto%', idConjunto);

            $.get( rutaFinal , function(response){

                var selectExtensiones = $('select[name="idExtension"]');
                $(selectExtensiones).empty();


                optionTag = $('<option>', {value: '', text: 'Selección'});
                $(selectExtensiones).append(optionTag);

                $(response.data).each(function(index, element){

                    statusDisabled = false;
                    textOption = element.extension;
                    optionTag = $('<option>', {value: element.id_extension, text: textOption, disabled:statusDisabled});
                    $(selectExtensiones).append(optionTag);
                });

            }).
            fail(function(){
                swal ( "{{trans('generales.sweet_alert.error.titulo')}}" ,  "{{trans('generales.sweet_alert.error.texto')}}" ,  "error" );
                return null;
            });

        };

        @if($errors->first('idExtension'))
        $('#ModalExten').modal();
        @endif

    </script>
@endsection