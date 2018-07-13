@extends('public.layouts.app')
@extends('public.layouts.seccion')
@section('fondo')"{{ asset('titan/assets/images/fondo_1.jpg') }}" @endsection
@section('descripcion')Procesos para la autoevaluación @endsection
@section('titulo')Selección de Procesos @endsection
@section('content')
@component('admin.components.panel')
        {!! Form::open([
        'route' => 'public.encuestas.create',
        'method' => 'POST',
        'id' => 'form_cargar_encuestas',
        'class' => 'form-horizontal form-label-lef',
        'novalidate'
        ])!!}
        @include('public.Encuestas.form')
        <br></br>
        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
            {{ link_to_route('home',"Cancelar", [],
            ['class' => 'btn btn-danger btn-circle']) }}
            {!! Form::submit('Iniciar', ['class' => 'btn btn-success btn-circle']) !!}
            </div>
        </div>
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
<link href="{{ asset('gentella/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">

@push('scripts')
<!-- PNotify -->
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>
<script src="{{ asset('gentella/vendors/select2/dist/js/select2.full.min.js') }}"></script>

@endpush

@endpush

@push('functions')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#grupos').select2();
            var form = $('#form_cargar_encuestas');
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
                    success: function (response, NULL, jqXHR) {
                        window.location.href = " {{ route('public.encuestas.create')}} ";
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