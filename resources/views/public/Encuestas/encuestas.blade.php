@extends('public.layouts.app')
@extends('public.layouts.seccion')
@section('fondo')"{{ asset('titan/assets/images/fondo_1.jpg') }}" @endsection
@section('descripcion')Proceso de Autoevaluación @endsection
@section('titulo')Encuesta @endsection
@section('content')
@component('admin.components.panel')
        {!! Form::open([
        'route' => 'public.encuestas.store',
        'method' => 'POST',
        'id' => 'form_encuestas',
        'class' => 'form-horizontal form-label-lef',
        'novalidate'
        ])!!}
        @include('public.Encuestas.wizard')
        <br></br>
            {!! Form::close() !!}
        </div>
        </div>
    </div>   
    </section>
@endcomponent
@endsection

@push('styles')
<!-- PNotify -->
<link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
<link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
<link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
<link href="{{ asset('gentella/vendors/SmartWizard/dist/css/smart_wizard.css') }}" rel="stylesheet"type="text/css" />
<link href="{{ asset('gentella/vendors/SmartWizard/dist/css/smart_wizard_theme_dots.css') }}" rel="stylesheet"type="text/css" />

@endpush

@push('scripts')
<!-- PNotify -->
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>
<script src="{{ asset('gentella/vendors/SmartWizard/dist/js/jquery.smartWizard.min.js') }}"></script>
@endpush

@push('functions')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#smartwizard').smartWizard({
                selected: 0, 
                lang: { 
                next: 'Siguiente',
                previous: 'Anterior'
            },
            toolbarSettings: {
                showNextButton: true, 
                showPreviousButton: false, 
            }
        });
        $('.sw-btn-next').bind('click', function() {
            $('.sw-btn-next').hide();
            $('#finalizar').hide(); 
        });
        $(".radios").change(function () {
            $('.sw-btn-next').show();
            $('#finalizar').show();   
        });
        /*window.onbeforeunload = function(e) {
            alert('Sirve');
            window.location.href = " {{route('home')}} ";
        };*/
            var form = $('#form_encuestas');
            form.submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (response, NULL, jqXHR) {
                        new PNotify({
                            title: response.title,
                            text: response.msg,
                            type: 'success',
                            styling: 'bootstrap3'
                        });
                        window.location.href = " {{route('home')}} ";
                    },
                    error: function (data) {
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