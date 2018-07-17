@extends('public.layouts.app')
@extends('public.layouts.seccion')
@section('fondo')"{{ asset('titan/assets/images/fondo_1.jpg') }}" @endsection
@section('descripcion')Procesos para la autoevaluación @endsection
@section('titulo')Selección del grupo de interes @endsection
@section('content')
@component('admin.components.panel')
        {!! Form::open([
        'route' => 'public.encuestas.store',
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
@endpush

@push('scripts')}
<!-- validator -->
<script src="{{ asset('gentella/vendors/parsleyjs/parsley.min.js') }}"></script>
<script src="{{ asset('gentella/vendors/parsleyjs/i18n/es.js') }}"></script>
<!-- PNotify -->
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.js') }}"></script>
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
<script src="{{ asset('gentella/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>
<script src="{{ asset('gentella/vendors/select2/dist/js/select2.full.min.js') }}"></script>

@endpush
@push('functions')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#grupos').select2();
            $('#cargos').select2();
            $('#grupos').change(function (e) {
                e.preventDefault();
                var valor = $("#grupos option:selected").text();
                var id = $("#grupos option:selected").val();
                if(valor == "DIRECTIVOS ACADEMICOS")
                {
                    document.getElementById("container").classList.remove('hidden');
                }
                else
                {
                    document.getElementById("container").classList.add('hidden');
                }
            });
            var form = $('#form_cargar_encuestas');
            form.submit(function (e) {
                e.preventDefault();
                window.location.href = "{{ url('encuesta') . '/'. request()->route()->parameter('id') . '/' }}"+ $('#grupos').val() + '/' + $('#cargos').val() 
            });
        });
    </script>
@endpush