{{-- Titulo de la pagina --}}
@section('title', 'Reportes de Encuestas')

{{-- Contenido principal --}}
@extends('admin.layouts.app')
@section('content')
    @component('admin.components.panel')
        @slot('title', 'Reportes de Encuestas')
        @if(session()->get('id_proceso'))
        <div id="graficas" class="hidden">
        <div class="row">
        <div class="col-md-12 col-xs-20">
            <a href="#"class="btn btn-danger" id="pdf">
                <i class="fa fa-file-pdf-o"></i> PDF
            </a>
        </div>
        </div>
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
                    @include('autoevaluacion.FuentesPrimarias.Reportes.form')
                    
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
                    @include('autoevaluacion.FuentesPrimarias.Reportes._form')
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        @else
        Por favor seleccione un proceso
        @endif
        
    @endcomponent
    


@endsection

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
            $('#pdf').bind('click', function() {
                var doc = new jsPDF('vertical', 'mm', 'letter');
                doc.setFont("sans serif")
                doc.setFontSize(14);
                doc.setFontType('bold');
                html2canvas($("#pie_filtro"), {
                onrendered: function(canvas) {
                    var texto = $("#grupos option:selected").text();         
                    var imgData = canvas.toDataURL('image/png');                 
                    doc.text(70,25,"INFORME GENERAL ENCUESTAS");
                    doc.text(20,40,'{{ Session::get('proceso')}}');
                    doc.text(20,55,texto);
                    doc.addImage(imgData, 'PNG',5,65,0,70); 
                    doc.addHTML(canvas);        
                    }       
                });
                html2canvas($("#encuestados"), {
                onrendered: function(canvas) {     
                    var imgData = canvas.toDataURL('image/png');                  
                    doc.text(100,150,"Muestra");
                    doc.addImage(imgData, 'PNG',5,160,0,100); 
                    doc.addHTML(canvas);          
                    }       
                });
                html2canvas($("#caracteristicas"), {
                onrendered: function(canvas) {
                    doc.addPage();  
                    var factor = $("#factor option:selected").text();         
                    var imgData = canvas.toDataURL('image/png');             
                    doc.text(75,25,"Ponderacion Caracteristicas");
                    doc.text(20,45,factor);
                    doc.addImage(imgData, 'PNG',5,60,0,48); 
                    doc.addHTML(canvas);
                    doc.save("informe_encuestas"+'gt_log.pdf');             
                    }       
                });

            });
            @endif
        });
    </script>
@endpush