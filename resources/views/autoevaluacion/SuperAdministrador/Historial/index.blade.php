{{-- Titulo de la pagina --}} 
@section('title', 'Historial') {{-- Contenido principal --}} 
@extends('admin.layouts.app')

@section('content') @component('admin.components.panel') @slot('title', 'Historial')
<div class="row">
    <form action="#" method="post" id="form_selecionar_proceso">
        <div class=" col-md-6 col-sm-6 col-xs-12">
            {!! Form::label('anio', 'Año', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!} {!! Form::select('anio', isset($procesos_anios)?$procesos_anios:[],
            old('anio'), ['class' => 'select2 form-control', 'placeholder' => 'Seleccione un año', 'required' => '', 'id'
            => 'proceso_anio']) !!}
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            {!! Form::label('PK_PCS_Id', 'Proceso', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) !!} {!! Form::select('PK_PCS_Id',
            isset($procesos_historial)?$procesos_historial:[], old('PK_PCS_Id'), ['class' => 'select2 form-control', 'placeholder'
            => 'Seleccione un proceso', 'required' => '', 'id' => 'proceso_historial']) !!}
        </div>
    </form>
</div>

<div id="graficas" class="hidden">
    <h3>Reporte Documental</h3>
    <hr>

    <div class="row">
        <div class="col-xs-12">
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                    style="width:40%;color:black">

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-12">
            <canvas id="pie_completado" height="220"></canvas>
        </div>
        <div class="col-md-6 col-xs-12">
            <canvas id="fechas_cantidad" height="220"></canvas>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        {!! Form::open(['method' => 'POST', 'id' => 'form_filtros_documental',
        'class' => 'form-horizontal form-label-left', 'novalidate' ])!!}
        <div class="col-xs-12">
    @include('autoevaluacion.SuperAdministrador.Historial._form_documental')

            <div class="col-xs-12">
                <hr />
            </div>
            <canvas id="documentos_indicador" height="150"></canvas>
        </div>
        {!! Form::close() !!}
    </div>
    <hr>
    <h3>Reporte Encuestas</h3>
    <hr>

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <canvas id="pie_filtro" height="100"></canvas>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        {{-- {!! Form::open([ 'route' => 'primarias.informe_encuestas.filtrar', 'method' => 'POST', 'id' => 'form_filtros_encuestas',
        'class' => 'form-horizontal form-label-left', 'novalidate' ])!!} --}}
        <div class="col-xs-12">
            {{--
    @include('admin.dashboard._form_reportes encuestas1') --}}

            <div class="col-xs-12">
                <hr />
            </div>
            <canvas id="encuestados" height="150"></canvas>
        </div>
        <div class="col-xs-12">
            <div class="col-xs-12">
                <hr />
            </div>
            </br>
            <canvas id="caracteristicas" height="70"></canvas>
            </br>
            </br>
            {{--
    @include('admin.dashboard._form_reportes_encuestas2') --}}
        </div>
        {!! Form::close() !!}
    </div>
</div>
</div>

</div>

@endcomponent
@endsection
 @can('SUPERADMINISTRADOR') {{-- Scripts necesarios para el formulario --}} @push('scripts')
<!-- Char js -->
<script src="{{ asset('gentella/vendors/Chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('js/charts.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('gentella/vendors/select2/dist/js/select2.full.min.js') }}"></script>



@endpush {{-- Estilos necesarios para el formulario --}} @push('styles')
<link href="{{ asset('gentella/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet"> 
@endpush {{-- Funciones necesarias por el formulario --}} @push('functions')
<script type="text/javascript">
    $(document).ready(function () {
            $('#proceso_historial').select2();
            $('#proceso_anio').select2();
             $('#factor_documental').select2({
                        language: "es"
                    });
            $('#caracteristica').select2({ 
                language: "es" 
            }); 

            selectDinamico("#proceso_anio", "#proceso_historial", "{{url('admin/historial/proceso')}}");
            selectDinamico("#factor_documental", "#caracteristica", 
            "{{url('admin/historial/caracteristicas')}}");

            $("#proceso_historial").change(function (e) {
                if (this.value != '') {
                    peticionGraficasHistorial( '{{ url('admin/historial/datos_graficas') }}' + '/' +  this.value);
                }
            });

            var form_documental = $('#form_filtros_documental');

            $("#factor_documental, #caracteristica").change(function () {
                url = '{{ url('admin/historial/filtro_documental') }}' + '/' + $('#proceso_historial').val();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: form_documental.serialize(),
                    dataType: 'json',
                    success: function (r) {
                        ChartFiltro.destroy();
                        ChartFiltro = crearGrafica('documentos_indicador', 'bar', 'Documentos subidos por indicador', 
                        r.labels_indicador, ['Cantidad'], r.data_indicador
                        );
                    }
                });
            });
        });

</script>



@endpush @endcan