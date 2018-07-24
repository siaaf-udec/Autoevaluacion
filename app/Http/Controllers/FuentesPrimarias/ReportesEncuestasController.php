<?php

namespace App\Http\Controllers\FuentesPrimarias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Encuesta;
use App\Models\Encuestado;
use App\Models\PreguntaEncuesta;
use App\Models\RespuestaPregunta;
use App\Models\Pregunta;
use App\Models\Proceso;
use App\Models\Factor;
use App\Models\Caracteristica;
use App\Models\SolucionEncuesta;

class ReportesEncuestasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grupos = PreguntaEncuesta::whereHas('grupos', function ($query) {
            return $query->where('FK_GIT_Estado','=' ,'1');
        })
        ->get()->pluck('grupos.GIT_Nombre', 'grupos.PK_GIT_Id');
        $id_lineamiento = Proceso::find(session()->get('id_proceso'))->FK_PCS_Lineamiento ?? null;
        $factores = Factor::where('FK_FCT_Lineamiento','=',$id_lineamiento)
        ->get()->pluck('FCT_Nombre','PK_FCT_Id');
        return view('autoevaluacion.FuentesPrimarias.Reportes.index',compact('grupos','factores'));
    }
    public function obtenerDatos(Request $request)
    {
        //encuestados
        $encuesta = Encuesta::where('FK_ECT_Proceso','=',session()->get('id_proceso'))->first();
        $encuestados = Encuestado::with('grupos')
        ->where('FK_ECD_Encuesta','=',$encuesta->PK_ECT_Id)
        ->selectRaw('*, COUNT(FK_ECD_GrupoInteres) as cantidad')
        ->groupby('FK_ECD_GrupoInteres')
        ->get();
        $labels_encuestado = [];
        $data_encuestado = [];
        foreach ($encuestados as $encuestado) {
            array_push($labels_encuestado,$encuestado->grupos->GIT_Nombre);
            array_push($data_encuestado, $encuestado->cantidad);
        }
        //caracteristicas
        $labels_caracteristicas = [];
        $data_caracteristicas = [];
        $data_factor = [];
        
        $caracteristicas = Caracteristica::with('factor','preguntas.respuestas')
        ->where('FK_CRT_Factor','=','1')
        ->get();
        array_push($data_factor,Factor::where('FCT_Identificador','1')->first()->FCT_Nombre);
        foreach($caracteristicas as $caracteristica)
        {
            array_push($labels_caracteristicas,$caracteristica->CRT_Nombre);
            $preguntas = Pregunta::where('FK_PGT_Caracteristica','=',$caracteristica->PK_CRT_Id)->get();
            foreach($preguntas as $pregunta)
            {
                $respuestas = SolucionEncuesta::whereHas('respuestas', function ($query) use ($pregunta){
                    return $query->where('FK_RPG_Pregunta', '=', $pregunta->PK_PGT_Id);
                })
                ->get();
                $totalponderacion = 0.0;
                foreach($respuestas as $respuesta)
                {
                    $ponderacion = RespuestaPregunta::whereHas('ponderacion', function ($query) use ($respuesta){
                        return $query->where('PK_RPG_Id', '=', $respuesta->FK_SEC_Respuesta);
                    })
                    ->with('ponderacion')->first();
                    $totalponderacion = $totalponderacion + $ponderacion->ponderacion->PRT_Ponderacion;
                }
                array_push($data_caracteristicas, $totalponderacion);
            }
        }
        $datos = [];
        $datos['labels_encuestado'] = $labels_encuestado;
        $datos['data_encuestado'] = array($data_encuestado);
        $datos['labels_caracteristicas'] = $labels_caracteristicas;
        $datos['data_caracteristicas'] = array($data_caracteristicas);
        $datos['data_factor'] = array($data_factor);
        return json_encode($datos);
    }
    public function filtro(Request $request)
    {
        $preguntas = Pregunta::findOrFail($request->get('PK_PGT_Id'));
        $respuestas = RespuestaPregunta::selectRaw('PK_RPG_Id,FK_RPG_Pregunta,SUBSTRING(RPG_Texto,1,170) as RPG_Texto')
        ->where('FK_RPG_Pregunta','=',$request->get('PK_PGT_Id'))
        ->get();
        $encuesta = Encuesta::where('FK_ECT_Proceso','=',session()->get('id_proceso'))
        ->first();
        $encuestados = Encuestado::selectRaw('COUNT(FK_ECD_GrupoInteres) as cantidad')
        ->where('FK_ECD_Encuesta','=',$encuesta->PK_ECT_Id)
        ->where('FK_ECD_GrupoInteres','=',$request->get('PK_GIT_Id'))
        ->first();
        $labels_respuestas = [];
        $data_respuestas = [];
        $data_titulo = [];
        array_push($data_titulo, $preguntas->PGT_Texto);
        foreach ($respuestas as $respuesta) {
            $total_respuestas = SolucionEncuesta::whereHas('encuestados', function ($query) use ($request){
                return $query->where('FK_ECD_GrupoInteres', '=', $request->get('PK_GIT_Id'));
            })
            ->where('FK_SEC_Respuesta','=',$respuesta->PK_RPG_Id)
            ->get();
            array_push($labels_respuestas, $respuesta->RPG_Texto." ".number_format($total_respuestas->count()*100/$encuestados->cantidad,1)."%");
            array_push($data_respuestas, $total_respuestas->count());
        }
        $datos = [];
        $datos['labels_respuestas'] = $labels_respuestas;
        $datos['data_respuestas'] = array($data_respuestas);
        $datos['data_titulo'] = array($data_titulo);
        return json_encode($datos);

    }
    public function obtenerPreguntas($id)
    {
        $encuesta = Encuesta::where('FK_ECT_Proceso','=',session()->get('id_proceso'))->first();
        $preguntas = PreguntaEncuesta::whereHas('preguntas', function ($query) {
            return $query->where('FK_PGT_Estado', '1');
        })
        ->with('preguntas')
        ->where('FK_PEN_GrupoInteres', '=', $id)
        ->where('FK_PEN_Banco_Encuestas', '=', $encuesta->FK_ECT_Banco_Encuestas)
        ->get()->pluck('preguntas.PGT_Texto','preguntas.PK_PGT_Id');
        return json_encode($preguntas);
    }
    public function filtro_factores(Request $request)
    {
        //caracteristicas
        $labels_caracteristicas = [];
        $data_caracteristicas = [];
        $data_factor = [];
        
        $caracteristicas = Caracteristica::with('factor','preguntas.respuestas')
        ->where('FK_CRT_Factor','=',$request->get('PK_FCT_Id'))
        ->get();
        array_push($data_factor,Factor::where('PK_FCT_Id',$request->get('PK_FCT_Id'))->first()->FCT_Nombre);
        foreach($caracteristicas as $caracteristica)
        {
            array_push($labels_caracteristicas,$caracteristica->CRT_Nombre);
            $preguntas = Pregunta::where('FK_PGT_Caracteristica','=',$caracteristica->PK_CRT_Id)->get();
            $totalponderacion = 0.0;
            foreach($preguntas as $pregunta)
            {
                $respuestas = SolucionEncuesta::whereHas('respuestas', function ($query) use ($pregunta){
                    return $query->where('FK_RPG_Pregunta', '=', $pregunta->PK_PGT_Id);
                })
                ->get();
                foreach($respuestas as $respuesta)
                {
                    $ponderacion = RespuestaPregunta::whereHas('ponderacion', function ($query) use ($respuesta){
                        return $query->where('PK_RPG_Id', '=', $respuesta->FK_SEC_Respuesta);
                    })
                    ->with('ponderacion')->first();
                    $totalponderacion = $totalponderacion + $ponderacion->ponderacion->PRT_Ponderacion;
                }
                array_push($data_caracteristicas, $totalponderacion);
            }
        }
        $datos = [];
        $datos['labels_caracteristicas'] = $labels_caracteristicas;
        $datos['data_caracteristicas'] = array($data_caracteristicas);
        $datos['data_factor'] = array($data_factor);
        return json_encode($datos);

    }
}
