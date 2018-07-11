@extends('public.layouts.app')
@section('content')
<section class="module bg-dark-30 about-page-header" data-background="{{ asset('titan/assets/images/fondo_1.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <h1 class="module-title font-alt mb-0">Procesos para la autoevaluación</h1>
            </div>
        </div>
    </div>
</section>
<section class="module">
<div class="container">
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
<h4 class="font-alt mb-0">Selección de Procesos</h4>
<hr class="divider-w mt-10 mb-20">
@component('admin.components.panel')
        {!! Form::open([
        'route' => 'admin.procesos_programas.store',
        'method' => 'POST',
        'id' => 'form_crear_procesos_programas',
        'class' => 'form-horizontal form-label-lef',
        'novalidate'
        ])!!}
        @include('public.layouts.Encuestas.form')
        <br></br><br></br>
        <div class="ln_solid"></div>
        <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
        {{ link_to_route('admin.procesos_programas.index',"Cancelar", [],
        ['class' => 'btn btn-danger btn-circle']) }}
        {!! Form::submit('Continuar', ['class' => 'btn btn-success btn-circle']) !!}
        </div>
        </div>
        {!! Form::close() !!}
        </div>
        </div>
    </div>   
    </section>
@endcomponent
@endsection
