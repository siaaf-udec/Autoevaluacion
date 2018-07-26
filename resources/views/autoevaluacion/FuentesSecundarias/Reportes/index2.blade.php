{{-- Titulo de la pagina --}}
@section('title', 'Reportes documentales')

{{-- Contenido principal --}}
@extends('admin.layouts.app')
@section('content')
    @component('admin.components.panel')
        @slot('title', 'Reportes documentales')
        <div class="col-md-12 col-xs-20">
            <a href="#"class="btn btn-danger" id="pdf">
                <i class="fa fa-file-pdf-o"></i> PDF
            </a>
        </div>
        <div class="row">
                <div class="col-md-6 col-xs-12">
                    <canvas id="documentos_institucionales" height="220"></canvas>
                </div>
                <div class="col-md-6 col-xs-12">
                    <canvas id="historial_institucionales" height="220"></canvas>
                </div>
        </div>

    @endcomponent
    


@endsection

{{-- Scripts necesarios para el formulario --}} 
@push('scripts')
    <!-- Char js -->
    <script src="{{ asset('gentella/vendors/Chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/charts.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('gentella/vendors/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- pdf -->
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
            
            $.ajax({
                    url: "{{ route('documental.informe_documental.data') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function (r) {
                       crearGrafica('historial_institucionales', 'line', 'Historial Documentos institucionales',
                        r.labels_fecha, ['cantidad'], r.data_fecha
                        );
                        ChartFiltro = crearGrafica('documentos_institucionales', 'pie', 'Documentos institucionales',
                        r.labels_documento, ['cantidad'], r.data_documento
                        );
                    }
                });
                $('#pdf').bind('click', function() {
                 var doc = new jsPDF('vertical', 'mm', 'letter');
                doc.setFont("sans serif");
                doc.setFontSize(14);
                doc.setFontType('bold');
                doc.setProperties({
                        title: 'Informe Documentos Institucionales',
                        subject: 'Documentos Institucionales',
                        author: 'SIA V3.0',
                        keywords: 'generated, javascript, web 2.0, ajax',
                        creator: 'create with jspdf'
                });

                html2canvas($("#documentos_institucionales"), {
                onrendered: function(canvas) {  
                    var imgData = canvas.toDataURL({
                    format: 'jpeg',
                    quality: 10
                    });              
                    doc.text(75,25,"INFORME GENERAL DOCUMENTAL");
                    doc.text(85,45,"Documentos Institucionales");
                    doc.addImage(imgData, 'PNG',40,50,145,110); 
                    doc.addHTML(canvas);        
                    }       
                });
                html2canvas($("#historial_institucionales"), {
                onrendered: function(canvas) {       
                    doc.addPage('vertical', 'mm', 'letter');                    
                    var imgData = canvas.toDataURL('image/png');                  
                    doc.text(70,45,"Historial documentos institucionales");
                    doc.addImage(imgData, 'PNG',40,50,145,110); 
                    doc.addHTML(canvas);
                    doc.save("Informe_documental.pdf");             
                    }       
                });
            });
        });
        
        
    </script>
@endpush