@extends('admin.layouts.app')
@section('content')
    @component('admin.components.panel')
            @slot('title', 'Crear Datos Especificos')
            {!! Form::open([
                'route' => 'fuentesP.datosEspecificos.store',
                'method' => 'POST', 
                'id' => 'form_crear_datosEspecificos',
                'class' => 'form-horizontal form-label-lef',
                'novalidate'
            ])!!}
            @include('autoevaluacion.FuentesPrimarias.DatosEspecificos.form')
            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-5 col-md-offset-3">
                    {{ link_to_route('fuentesP.datosEspecificos.index',"Cancelar", [], ['class' => 'btn btn-info']) }}
                    {!! Form::submit('Crear Datos', ['class' => 'btn btn-success']) !!}
                </div>
            </div>
        {!! Form::close() !!}
    @endcomponent
@endsection

@push('styles')
<!-- PNotify -->
<link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
<link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
<link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">

<link href="{{ asset('gentella/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">

<link href="{{ asset('gentella/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
<link href="{{ asset('gentella/vendors/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
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
<script src="{{asset('gentella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>
@endpush
@push('functions')
<script type="text/javascript">
            $('#estado').select2();
            $('#sede').select2();
            $('#proceso').select2();
            $('#grupo').select2();
            $('#descripcion').select2();
            selectDinamico("#sede","#proceso","{{url('admin/procesos')}}");
            selectDinamico("#grupo","#descripcion","{{url('admin/fuentesPrimarias/encuestas')}}");
            var form = $('#form_crear_datosEspecificos');
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
            form.submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url     : form.attr('action'),
                    type    : form.attr('method'),
                    data    : form.serialize(),
                    dataType: 'json',
                    success: function (response, NULL, jqXHR) {
                        $(form)[0].reset();
                        $(form).parsley().reset();
                        new PNotify({
                            title: response.title,
                            text: response.msg,
                            type: 'success',
                            styling: 'bootstrap3'
                        });
                    },
                    error: function (data) {
                        var errores = data.responseJSON.errors;
                        var msg = '';
                        $.each(errores, function(name, val) {
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
</script>
@endpush