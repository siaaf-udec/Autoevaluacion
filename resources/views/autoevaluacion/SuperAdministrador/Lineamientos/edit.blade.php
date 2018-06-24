@extends('admin.layouts.app') 
@section('content') 
@component('admin.components.panel') @slot('title', 'Modificar Lineamiento') {!!
Form::model($lineamiento, [ 'route' => ['admin.lineamientos.update', $lineamiento], 'method' => 'PUT', 'id' => 'form_modificar_lineamiento', 'class' =>
'form-horizontal form-label-lef', 'novalidate' ])!!}
    @include('autoevaluacion.SuperAdministrador.Lineamientos._form')
<div class="ln_solid"></div>
<div class="form-group">
    <div class="col-md-6 col-md-offset-3">

        {{ link_to_route('admin.lineamientos.index',"Cancelar", [], ['class' => 'btn btn-info']) }} 
        {!! Form::submit('Modificar Lineamiento', ['class'
        => 'btn btn-success']) !!}
    </div>
</div>
{!! Form::close() !!} @endcomponent
@endsection
 @push('styles')
<!-- PNotify -->
<link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
<link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.css') }}" rel="stylesheet">
<link href="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">

@endpush @push('scripts')
<!-- validator -->
<script src="{{ asset('gentella/vendors/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('gentella/vendors/parsleyjs/i18n/es.js') }}"></script>
<!-- PNotify -->
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>


@endpush @push('functions')
<script type="text/javascript">
    $(document).ready(function() {
        
            var form = $('#form_modificar_lineamiento');
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
                    Accept: 'application/json',
                    success: function (response, NULL, jqXHR) {
                        sessionStorage.setItem('update', 'El Lineamiento se ha modificado exitosamente.');
                        
                        window.location.replace(" {{ route('admin.lineamientos.index')}} ");
                    },
                    error: function (data) {
                        console.log(data);
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
        });

</script>



@endpush