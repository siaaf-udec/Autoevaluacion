@extends('admin.layouts.app')
@section('content') @component('admin.components.panel') @slot('title', 'Modificar Pregunta')
{!! Form::model($pregunta, [ 'route' => ['fuentesP.preguntas.update', $pregunta], 'method' => 'PUT', 'id' => 'form_modificar_pregunta',
'class' => 'form-horizontal form-label-lef', 'novalidate' ])!!}
@include('autoevaluacion.FuentesPrimarias.Preguntas._form')
<div class="ln_solid"></div>
<div class="form-group">
    <div class="col-md-6 col-md-offset-3">

        {{ link_to_route('fuentesP.preguntas.index',"Cancelar", [], ['class' => 'btn btn-info']) }} {!! Form::submit('Modificar Pregunta',
        ['class' => 'btn btn-success']) !!}
    </div>
</div>
{!! Form::close() !!} @endcomponent
@endsection
@push('styles')
    <!-- PNotify -->
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
    <!-- Select2 -->
    <link href="{{ asset('gentella/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
@endpush @push('scripts')
    <script src="{{ asset('js/admin.js') }}"></script>
    <!-- validator -->
    <script src="{{ asset('gentella/vendors/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('gentella/vendors/parsleyjs/i18n/es.js') }}"></script>
    <!-- PNotify -->
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('gentella/vendors/select2/dist/js/select2.full.min.js') }}"></script>

@endpush @push('functions')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#factor').select2();
            $('#caracteristica').select2();
            $('#tipo').select2();
            $('#estado').select2();
            selectDinamico("#factor", "#caracteristica", "{{url('admin/caracteristicas')}}");
            $('#tipo').change(function () {
                var number = $("#tipo option:selected").text()
                var container = document.getElementById("container");
                while (container.hasChildNodes()) {
                    container.removeChild(container.lastChild);
                }
                for (i=1;i<=number;i++){
                container.appendChild(document.createTextNode("Respuesta " + (i)));
                var input = document.createElement("input");
                input.type = "text";
                input.name = "Respuesta_" + i;
                input.maxLength = 5000;
                input.required = true;
                input.size = 67;
                input.pattern = "^[a-zA-Z ][a-zA-Z0-9-_\. ]{1,5000}$";
                container.appendChild(input);
                container.appendChild(document.createElement("br"));
            }
            });
            $('#factor').prop('disabled', false);
            $('#caracteristica').prop('disabled', false);
            var form = $('#form_modificar_pregunta');
            $(form).parsley({
                trigger: 'change',
                successClass: "has-success",
                errorClass: "has-error",
                classHandler: function (el) {
                    return el.$element.closest('.form-group');
                },
                errorsWrapper: '<p class="help-block help-block-error"></p>',
                errorTemplate: '<span></span>',
            });


            form.submit(function (e) {

                e.preventDefault();
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    dataType: 'json',
                    Accept: 'application/json',
                    success: function (response, NULL, jqXHR) {
                        sessionStorage.setItem('update', 'La pregunta se ha modificado exitosamente.');

                        window.location.replace(" {{ route('fuentesP.preguntas.index')}} ");
                    },
                    error: function (data) {
                        console.log(data);
                        var errores = data.responseJSON.errors;
                        var msg = '';
                        $.each(errores, function (name, val) {
                            msg += val + '<br>';
                        });
                        new PNotify({
                            title: "Error!",
                            text: msg,
                            type: 'error',
                            styling: 'bootstrap3'
                        });
                    }
                });
            });
        });

    </script>


@endpush
