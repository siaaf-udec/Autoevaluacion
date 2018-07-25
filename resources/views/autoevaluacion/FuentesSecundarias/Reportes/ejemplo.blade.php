<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>informe documental</title>
<style>
	h1{
		text-align: center;
		text-transform: uppercase;
	}
	.contenido{
		font-size: 20px;
	}
	#primero{
		background-color: #ccc;
	}
	#segundo{
		color:#44a359;
	}
	#tercero{
		text-decoration:line-through;
	}
</style>
</head>
<body>
	<h1>Informe Documental</h1>
	<hr>
	<div class="contenido">
	<div class="row">
                <div class="col-md-6 col-xs-12">
                    <canvas id="documentos_institucionales" height="220"></canvas>
                </div>
                <div class="col-md-6 col-xs-12">
                    <canvas id="historial_institucionales" height="220"></canvas>
                </div>
        </div>
	</div>
</body>
</html>
@push('scripts')
    <!-- Char js -->
    <script src="{{ asset('gentella/vendors/Chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/charts.js') }}"></script>
 
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
        });
    </script>
@endpush