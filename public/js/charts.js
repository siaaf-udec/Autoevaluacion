function crearGrafica(canvas = null, tipo, titulo = null,  etiquetas, etiquetasData, data = null) {
    var dynamicColorsArray = function (cantidad) {
        let colors =[];
        for (let i = 0; i < cantidad; i++) {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            colors.push("rgb(" + r + "," + g + "," + b + ")");
        }
        return colors

    };

    var dynamicColors = function () {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgb(" + r + "," + g + "," + b + ")";
    };

    var dataset = [];

    for (let i = 0; i < etiquetasData.length; i++){
        let aux = {};
        aux['label'] = etiquetasData[i];
        aux['data'] = data[i];
        if(tipo != 'line'){
            aux['backgroundColor'] = dynamicColorsArray(data[i].length);
        }
        else{    
            aux['borderColor'] = dynamicColors();
            aux['fill'] = false;
        }
        dataset.push(aux);
    }
    
   
    var jsonChart = {
        type: tipo,
        data: {
            labels: etiquetas,
            datasets: dataset,
        },
        options:{
            title:{
                display:true,
                text: titulo
            },

        },
    };

    var ctx = document.getElementById(canvas).getContext('2d');
    var myChart = new Chart(ctx, jsonChart);
    
    return myChart;
}

function crearGraficaBar(canvas = null, tipo, titulo = null,  etiquetas, etiquetasData, data = null) {
    var dynamicColorsArray = function (cantidad) {
        let colors =[];
        for (let i = 0; i < cantidad; i++) {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            colors.push("rgb(" + r + "," + g + "," + b + ")");
        }
        return colors

    };

    var dynamicColors = function () {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgb(" + r + "," + g + "," + b + ")";
    };

    var dataset = [];

    for (let i = 0; i < etiquetasData.length; i++){
        let aux = {};
        aux['label'] = etiquetasData[i];
        aux['data'] = data[i];
        if(tipo != 'line'){
            aux['backgroundColor'] = dynamicColorsArray(data[i].length);
        }
        else{    
            aux['borderColor'] = dynamicColors();
            aux['fill'] = false;
        }
        dataset.push(aux);
    }
    
   
    var jsonChart = {
        type: tipo,
        data: {
            labels: etiquetas,
            datasets: dataset,
        },
        options:{
            "animation": {
                "duration": 1,
                "onComplete": function() {
                  var chartInstance = this.chart,
                    ctx = chartInstance.ctx;
          
                  ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                  ctx.textAlign = 'center';
                  ctx.textBaseline = 'bottom';
          
                  this.data.datasets.forEach(function(dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function(bar, index) {
                      var data = dataset.data[index];
                      ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                  });
                }
              },
            scaleShowValues: true,
            scales: {
                yAxes: [{
                    ticks: {
                        stepSize: 1,
                        beginAtZero: true
                    }
                }],
                xAxes: [{
                    ticks: {
                        min: 0,
                        autoSkip: false
                    }
                }]
            },
            responsive: true,
            title:{
                display:true,
                text: titulo
            }
        },
    };

    var ctx = document.getElementById(canvas).getContext('2d');
    var myChart = new Chart(ctx, jsonChart);
    
    return myChart;
}

var ChartFiltro;

function peticionGraficasDocumentales(ruta) {
     $.ajax({
         url: ruta,
         type: 'GET',
         dataType: 'json',
         success: function (r) {
            $('.progress-bar').css('width', r.completado + '%').attr('aria-valuenow', r.completado);
            $('#graficas').removeClass('hidden');
            $('.progress-bar').text(r.completado + '% completado')
             
            
            crearGrafica('pie_completado', 'pie', 'Grado de completitud', ['Completado', 'Faltante'], ['adasd'], r.dataPie);
            crearGrafica('fechas_cantidad', 'line', 'Cantidad de archivos subidos por fecha',
                r.labels_fecha, ['cantidad'], r.data_fechas);

            ChartFiltro = crearGrafica('documentos_indicador', 'bar', 'Documentos subidos por indicador', r.labels_indicador,
                ['Cantidad'], r.data_indicador
            );
             
         },
         error: function () {
             alert('Ocurrio un error en el servidor ...');
         }
     });
}
var filtro;
var caracteristicas;
function peticionGraficasEncuestas(ruta) {
    $.ajax({
        url: ruta,
        type: 'GET',
        dataType: 'json',
        success: function (r) {
           $('#graficas').removeClass('hidden');
           filtro = crearGrafica('pie_filtro', 'doughnut',"Cantidad de Encuestados", r.labels_encuestado, ['adasd'], r.data_encuestado);
           crearGraficaBar('encuestados', 'bar', 'Cantidad de Encuestados', r.labels_encuestado,['Cantidad'], r.data_encuestado);
           caracteristicas = crearGraficaBar('caracteristicas', 'horizontalBar', r.data_factor, r.labels_caracteristicas,
           ['Valorización'], r.data_caracteristicas);
        },
        error: function(xhr,err)
        {
            alert("readyState: "+err.readyState+"\nstatus: "+err.status);
            alert("responseText: "+err.responseText);
        }
    });
}