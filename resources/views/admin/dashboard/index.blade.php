{{-- Titulo de la pagina --}}
@section('title', 'Home')
{{-- Contenido principal --}}
@extends('admin.layouts.app')

@section('content')
    @component('admin.components.panel')
        @slot('title', 'Bienvenido a la plataforma Sia.')
        @can('SUPERADMINISTRADOR')

         @if(session()->get('id_proceso'))

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
                {!! Form::open([
                        'route' => 'documental.informe_documental.filtrar', 
                        'method' => 'POST',
                        'id' => 'form_filtros',
                        'class' => 'form-horizontal form-label-left',
                        'novalidate'
                ])!!}
                <div class="col-xs-12">
                    @include('admin.dashboard._form_reportes_documentales')
                    
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
                    {!! Form::open([
                            'route' => 'primarias.informe_encuestas.filtrar', 
                            'method' => 'POST',
                            'id' => 'form_filtros',
                            'class' => 'form-horizontal form-label-left',
                            'novalidate'
                    ])!!}
                    <div class="col-xs-12">
                        @include('admin.dashboard._form_reportes encuestas1')
                        
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
                        </br></br>
                        @include('admin.dashboard._form_reportes_encuestas2')
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @else
        Por favor seleccione un proceso
        @endif
        
        @endcan
    @endcomponent
@endsection

@can('SUPERADMINISTRADOR')

    {{-- Scripts necesarios para el formulario --}} 
    @push('scripts')
    <!-- Char js -->
    <script src="{{ asset('gentella/vendors/Chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/charts.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('gentella/vendors/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

    @endpush 

    {{-- Estilos necesarios para el formulario --}} 

    @push('styles')
    <link href="{{ asset('gentella/vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet"> 
    @endpush 
    
    {{-- Funciones necesarias por el formulario --}} 
    @push('functions')
    <script type="text/javascript">
        $(document).ready(function () {
                @if(session()->get('id_proceso'))

                //Documental
                    $('#factor_documental').select2({
                        language: "es"
                    });
                    $('#caracteristica').select2({ 
                        language: "es" 
                    }); 
                    $('#dependencia').select2({ 
                        language: "es" 
                    });
                    $('#tipo_documento').select2({ 
                        language: "es" 
                    });
                    selectDinamico("#factor_documental", "#caracteristica", "{{url('admin/documental/documentos_autoevaluacion/caracteristicas')}}", ['#indicador']);
                    
                    peticionGraficasDocumentales("{{ route('documental.informe_documental.datos') }}");

                    var form = $('#form_filtros');

                    $("#factor_documental, #caracteristica, #dependencia, #tipo_documento").change(function () {
                        $.ajax({
                            url: form.attr('action'),
                            type: form.attr('method'),
                            data: form.serialize(),
                            dataType: 'json',
                            success: function (r) {
                                ChartFiltro.destroy();
                                ChartFiltro = crearGrafica('documentos_indicador', 'bar', 'Documentos subidos por indicador', 
                                r.labels_indicador, ['Cantidad'], r.data_indicador
                                );
                            }
                        });
                    });

                    //Encuestas

                        var canvas = document.getElementById('pie_filtro');
                        $('#grupos').select2({
                            language: "es"
                        });
                        $('#preguntas').select2({
                            language: "es"
                        });
                        $('#factor').select2({
                            language: "es"
                        });
                        selectDinamico("#grupos", "#preguntas", "{{url('admin/fuentesPrimarias/grupos/preguntas')}}", ['#preguntas']);
                        peticionGraficasEncuestas("{{ route('primarias.informe_encuestas.datos') }}");
                        var form = $('#form_filtros');
                        $("#preguntas").change(function () {
                            console.log('asssa');
                            $.ajax({
                                url: form.attr('action'),
                                type: form.attr('method'),
                                data: form.serialize(),
                                dataType: 'json',
                                success: function (r) {
                                    filtro.destroy();
                                    filtro = crearGrafica('pie_filtro', 'doughnut', r.data_titulo, r.labels_respuestas, ['adasd'], r.data_respuestas);
                                }
                            });

                        });
                        $("#factor").change(function () {
                            console.log('asssa');
                            $.ajax({
                                url: "{{ route('primarias.informe_encuestas.filtrar_factores') }}",
                                type: form.attr('method'),
                                data: form.serialize(),
                                dataType: 'json',
                                success: function (r) {
                                    caracteristicas.destroy();
                                    caracteristicas = crearGraficaBar('caracteristicas', 'horizontalBar', r.data_factor, r.labels_caracteristicas,
                                    ['Valorizacion'], r.data_caracteristicas);
                                }
                            });

                        });
                @endif
            });
    </script>

    @endpush
@endcan