@extends('admin.layouts.app')
@section('content') @component('admin.components.panel') @slot('title', 'Modificar Proceso')
{!! Form::model($proceso, [ 'route' => ['admin.procesos_programas.update', $proceso], 'method' => 'PUT', 'id' => 'form_modificar_proceso',
'class' => 'form-horizontal form-label-lef', 'novalidate' ]) !!}
@include('autoevaluacion.SuperAdministrador.ProcesosProgramas._form')
<div class="ln_solid"></div>
<div class="form-group">
    <div class="col-md-6 col-md-offset-3">

        {{ link_to_route('admin.procesos_programas.index',"Cancelar", [], ['class' => 'btn btn-info']) }} {!! Form::submit('Modificar
        Proceso', ['class' => 'btn btn-success']) !!}
    </div>
</div>
{!! Form::close() !!} @endcomponent
@endsection
@push('styles')
    <!-- PNotify -->
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
    <link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ asset('gentella/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">

    <link href="{{ asset('gentella/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
@endpush @push('scripts')
    <!-- validator -->
    <script src="{{ asset('gentella/vendors/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('gentella/vendors/parsleyjs/i18n/es.js') }}"></script>
    <!-- PNotify -->
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
    <script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('gentella/vendors/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="{{asset('gentella/vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('gentella/vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

@endpush
@push('functions')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#sede, #facultad").change(function () {
                let sede = $('#sede').val();
                let facultad = $('#facultad').val();
                if (sede != '' && facultad != '') {
                    selectMultiplesParametros(['#sede', '#facultad'], [sede, facultad], '#programa', "{{url('admin/procesos_programas/')}}")
                }
            });

            $('#sede').select2();
            $('#facultad').select2();
            $('#programa').select2();
            $('#lineamiento').select2();
            $('#fase').select2();

            fecha('#fecha_fin');
            fecha('#fecha_inicio');

            var form = $('#form_modificar_proceso');
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
                        sessionStorage.setItem('update', 'El proceso se ha modificado correctamente.');
                        window.location.replace(" {{ route('admin.procesos_programas.index')}} ");
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