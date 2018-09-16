<?php

namespace App\Http\Controllers\FuentesSecundarias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\DocumentoAutoevaluacion;
use App\Models\Autoevaluacion\IndicadorDocumental;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\Dependencia;
use App\Models\Autoevaluacion\TipoDocumento;
use App\Models\Autoevaluacion\GrupoDocumento;
use App\Models\Autoevaluacion\DocumentoInstitucional;
use Barryvdh\DomPDF\Facade as PDF;


class ReporteController extends Controller
{
    public function index()
    {
        $id_lineamiento = Proceso::find(session()->get('id_proceso'))->FK_PCS_Lineamiento ?? null;

        $factores = Factor::has('caracteristica.indicadores_documentales')
            ->where('FK_FCT_Lineamiento', '=', $id_lineamiento)
            ->where('FK_FCT_estado', '=', '1')
            ->get()
            ->pluck('nombre_factor', 'PK_FCT_Id');
        $dependencias = Dependencia::pluck('DPC_Nombre', 'PK_DPC_Id');
        $tipo_documentos = TipoDocumento::pluck('TDO_Nombre', 'PK_TDO_Id');

        return view('autoevaluacion.FuentesSecundarias.Reportes.index',
            compact('factores', 'dependencias', 'tipo_documentos')
        );
    }

    public function obtenerDatos(Request $request)
    {
        $proceso = Proceso::find(session()->get('id_proceso'));
        $indicadores_documentales = IndicadorDocumental::whereHas('caracteristica.factor', function ($query) use ($proceso) {
            $query->where('FK_FCT_Lineamiento', '=', $proceso->FK_PCS_Lineamiento);
        })
            ->with('documentosAutoevaluacion', 'caracteristica')
            ->get();
        $documentosAux = DocumentoAutoevaluacion::with('indicadorDocumental')
            ->where('FK_DOA_Proceso', '=', session()->get('id_proceso'))
            ->oldest()
            ->get();


        $documentos = $documentosAux->groupBy('FK_DOA_IndicadorDocumental');

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
        $completado = ($documentos->count() / $indicadores_documentales->count()) * 100;
        $dataPie = [array($completado, 100 - $completado)];


        $datos = [];
        $datos['completado'] = $completado;
        $datos['dataPie'] = $dataPie;
        $datos['labels_fecha'] = $labels_fechas;
        $datos['data_fechas'] = array($data_fechas);
        $datos['labels_indicador'] = $labels_indicador;
        $datos['data_indicador'] = array($data_indicador);

        return json_encode($datos);
    }

    public function filtro(Request $request)
    {
        $proceso = Proceso::find(session()->get('id_proceso'));
        $id_factor = $request->get('PK_FCT_Id');
        $id_caracteristica = $request->get('PK_CRT_Id');
        $tipo_documento = $request->get('PK_TDO_Id');
        $dependencia = $request->get('PK_DPC_Id');

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
            ->with(['documentosAutoevaluacion' => function ($query) use ($tipo_documento, $dependencia) {
                return $query
                    ->when($tipo_documento, function ($q) use ($tipo_documento) {
                        return $q->where('FK_DOA_TipoDocumento', $tipo_documento);
                    })
                    ->when($dependencia, function ($q) use ($dependencia) {
                        return $q->where('FK_DOA_Dependencia', $dependencia);
                    });
            }])
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

    public function reportes()
    {
        return view('autoevaluacion.FuentesSecundarias.Reportes.index2');
    }

    public function obtenerDatosInst(Request $request)
    {
        $documentosAux = DocumentoInstitucional::with('grupodocumento')
            ->oldest()
            ->get();
        $documentosInst = $documentosAux->groupBy(function ($date) {
            return $date->created_at->format('Y-m-d');
        });


        //grafico historial fechas
        $labels_fechas = $documentosInst->keys()->toArray();
        $data_fechas = [];

        foreach ($documentosInst as $documentoInst) {
            array_push($data_fechas, $documentoInst->count());
        }


        //grafica documentos institucionales
        $labels_documento = [];
        $data_documento = [];
        $grupodocumento = GrupoDocumento::with('documentoinstitucional')
            ->get();
        foreach ($grupodocumento as $documentoInstitucional) {
            array_push($labels_documento, $documentoInstitucional->GRD_Nombre);
            array_push($data_documento, $documentoInstitucional->documentoinstitucional->count());
        }


        $datos = [];
        $datos['labels_fecha'] = $labels_fechas;
        $datos['data_fecha'] = array($data_fechas);
        $datos['labels_documento'] = $labels_documento;
        $datos['data_documento'] = array($data_documento);

        return json_encode($datos);
    }

    public function pdf_documento_autoevaluacion(Request $request)
    {
        $imagenes = explode('|', $request->get('json_datos'));
        $pdf = PDF::loadView('autoevaluacion.FuentesSecundarias.Reportes.pdf_documentos_autoevaluacion', compact('imagenes'));
        return $pdf->download('reporte_documental.pdf');
    }

    public function pdf_documentos_institucionales(Request $request)
    {
        $imagenes = explode('|', $request->get('json_datos'));
        $pdf = PDF::loadView('autoevaluacion.FuentesSecundarias.Reportes.pdf_documentos_institucionales', compact('imagenes'));
        return $pdf->download('reporte_documentos_institucionales.pdf');
    }

    

}
