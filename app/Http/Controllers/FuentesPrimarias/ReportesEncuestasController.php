<?php

namespace App\Http\Controllers\FuentesPrimarias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Encuesta;
use App\Models\Encuestado;
use App\Models\PreguntaEncuesta;
use App\Models\RespuestaPregunta;
use App\Models\Pregunta;
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
        return view('autoevaluacion.FuentesPrimarias.Reportes.index',compact("grupos"));
    }
    public function obtenerDatos(Request $request)
    {
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
        $datos = [];
        $datos['labels_encuestado'] = $labels_encuestado;
        $datos['data_encuestado'] = array($data_encuestado);
        return json_encode($datos);
    }
    public function filtro(Request $request)
    {
        $preguntas = Pregunta::findOrFail($request->get('PK_PGT_Id'));
        $respuestas = RespuestaPregunta::where('FK_RPG_Pregunta','=',$request->get('PK_PGT_Id'))
        ->get();
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
            array_push($labels_respuestas, $respuesta->RPG_Texto);
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
}
