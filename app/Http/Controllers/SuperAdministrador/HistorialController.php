<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Historial\Proceso;
use App\Models\Historial\IndicadorDocumental;
use App\Models\Historial\DocumentoProceso;
use Illuminate\Support\Carbon;
use App\Models\Historial\Factor;
use App\Models\Historial\Caracteristica;
use App\Models\Historial\SolucionEncuesta;

class HistorialController extends Controller
{
    public function index()
    {
        $procesos_historial = Proceso::pluck('PCS_Nombre', 'PK_PCS_Id');
        $procesos_anios = Proceso::orderBy('PCS_Anio_Proceso', 'desc')
            ->get()
            ->pluck('PCS_Anio_Proceso', 'PCS_Anio_Proceso');




        return view('autoevaluacion.SuperAdministrador.Historial.index', compact(
            'procesos_historial', 'procesos_anios'
        ));
    }

    public function obtenerProceso($anio)
    {
        $procesos = Proceso::where('PCS_Anio_Proceso', '=', $anio)
            ->get()
            ->pluck('PCS_Nombre', 'PK_PCS_Id');
        return json_encode($procesos);
    }

    public function obtenerDatosGraficas($id_proceso)
    {
        //Documental
        $proceso = Proceso::find($id_proceso);

        $indicadores_documentales = IndicadorDocumental::whereHas('caracteristica.factor', function ($query) use ($proceso) {
            $query->where('FK_FCT_Lineamiento', '=', $proceso->FK_PCS_Lineamiento);
        })
            ->with('documentosAutoevaluacion', 'caracteristica')
            ->get();
        $documentosAux = DocumentoProceso::with('indicadorDocumental')
            ->where('FK_DPC_Proceso', '=', $id_proceso)
            ->oldest()
            ->get();


        $documentos = $documentosAux->groupBy('FK_DPC_IndicadorDocumental');

        $documentosAuto = $documentosAux->groupBy(function ($date) {
            return $date->created_at->format('Y-m-d');
        });


        //Grafico barras
        $labels_indicador = [];
        $data_indicador = [];
        foreach ($indicadores_documentales as $documentoIndicador) {
            array_push($labels_indicador, $documentoIndicador->IDO_Nombre);
            array_push($data_indicador, $documentoIndicador->documentosAutoevaluacion->count());
        }


        //grafico historial fechas
        $labels_fechas = $documentosAuto->keys()->toArray();
        $data_fechas = [];

        foreach ($documentosAuto as $documentoAuto) {
            array_push($data_fechas, $documentoAuto->count());
        }

        //Grafico pie
        $completado = $proceso->PCS_Completitud_Documental;
        $dataPie = [array(number_format($completado, 1), 100 - number_format($completado, 1))];


        $datos = [];
        $datos['completado'] = number_format($completado, 1);
        $datos['dataPie'] = $dataPie;
        $datos['labels_fecha'] = $labels_fechas;
        $datos['data_fechas'] = array($data_fechas);
        $datos['labels_indicador'] = $labels_indicador;
        $datos['data_indicador'] = array($data_indicador);
        $datos['factores'] = Factor::has('caracteristica.indicadores_documentales')
            ->where('FK_FCT_Lineamiento', '=', $proceso->FK_PCS_Lineamiento)
            ->get()
            ->pluck('nombre_factor', 'PK_FCT_Id')
            ->toArray();

        //Encuestas

        //cantidad de encuestados
        $labels_encuestado = [];
        $data_encuestado = [];
        $encuestas_cantidad = SolucionEncuesta::whereHas('respuestas.pregunta', function($query) use($proceso){
                $query->where('FK_PGT_Proceso', '=', $proceso->PK_PCS_Id);
            })
            ->get()
            ->groupBy('SEC_Grupo_Interes');

        foreach ($encuestas_cantidad as $key => $encuestados) {
            array_push($labels_encuestado, $key);
            array_push($data_encuestado, $encuestados->count());
        }

        //valorizacion de las caracteristicas
        $labels_caracteristicas = [];
        $data_caracteristicas = [];
        $data_factor = [];

        $factor = Factor::where('FK_FCT_Lineamiento', '=', $proceso->FK_PCS_Lineamiento)->first();

        $caracteristicas = Caracteristica::whereHas('preguntas', function ($query) use($proceso){
                return $query->where('FK_PGT_Proceso', '=', $proceso->PK_PCS_Id);
            })
            ->whereHas('preguntas.respuestas.solucion')
            ->where('FK_CRT_Factor', '=', 4)
            ->with('preguntas.respuestas.solucion')
            ->get()
            ->groupBy('PK_CRT_Id');
        
        foreach ($caracteristicas as $key_caracteristica => $caracteristica) {
            array_push($labels_caracteristicas, $caracteristica[0]->CRT_Nombre);
            $total_ponderaciones = 0;
            $cantidad = 0;
            foreach ($caracteristica[0]->preguntas as $pregunta) {
                foreach ($pregunta->respuestas as $respuestas) {
                    foreach ($respuestas->solucion as $solucion) {
                        $cantidad++;
                        $total_ponderaciones = $total_ponderaciones + $solucion->SEC_Total_Ponderacion;
                    }
                }
            }
            $data = $total_ponderaciones != 0? $total_ponderaciones / $cantidad:0; 
            array_push($data_caracteristicas, $data);
        }

        $data_factor = Factor::where('FK_FCT_Lineamiento', '=', $proceso->FK_PCS_Lineamiento)
            ->get()
            ->pluck('FCT_Nombre', 'PK_FCT_Id');

        $datos['labels_encuestados'] = $labels_encuestado;
        $datos['data_encuestado'] = $data_encuestado;
        $datos['datos_factores'] = $data_factor;

        return json_encode($datos);
    }

    public function obtenerCaracteristicas($id_factor)
    {
        $caracteristicas = Caracteristica::has('indicadores_documentales')
            ->where('FK_CRT_Factor', '=', $id_factor)
            ->get()
            ->pluck('CRT_Nombre', 'PK_CRT_Id');
        return json_encode($caracteristicas);
    }

    public function filtroDocumental(Request $request, $id_proceso)
    {
        $proceso = Proceso::find($id_proceso);
        $id_factor = $request->get('PK_FCT_Id');
        $id_caracteristica = $request->get('PK_CRT_Id');

        /**
         * Se utilizan consultas con filtros para obtner diferentes resultados deseados por el
         * usuario
         */
        $indicadores_documentales = IndicadorDocumental::whereHas('caracteristica.factor', function ($query) use ($proceso, $id_factor) {
            $query->where('FK_FCT_Lineamiento', '=', $proceso->FK_PCS_Lineamiento)
                ->when($id_factor, function ($q) use ($id_factor) {
                    return $q->where('PK_FCT_Id', $id_factor);
                });
        })
            ->when($id_caracteristica, function ($q) use ($id_caracteristica) {
                return $q->where('FK_IDO_Caracteristica', $id_caracteristica);
            })
            ->get();

        //Grafico barras
        $labels_indicador = [];
        $data_indicador = [];
        foreach ($indicadores_documentales as $documentoIndicador) {
            array_push($labels_indicador, $documentoIndicador->IDO_Nombre);
            array_push($data_indicador, $documentoIndicador->documentosAutoevaluacion->count());
        }

        $datos = [];
        $datos['labels_indicador'] = $labels_indicador;
        $datos['data_indicador'] = array($data_indicador);

        return json_encode($datos);
    }
}
