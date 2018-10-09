<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\Encuesta;
use App\Models\Autoevaluacion\Encuestado;
use App\Models\Autoevaluacion\PreguntaEncuesta;
use App\Models\Autoevaluacion\RespuestaPregunta;
use App\Models\Autoevaluacion\Pregunta;
use App\Models\Autoevaluacion\GrupoInteres;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\SolucionEncuesta;
use App\Models\Autoevaluacion\PonderacionRespuesta;

class ReportesPlanMejoramientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_lineamiento = Proceso::find(session()->get('id_proceso'))->FK_PCS_Lineamiento ?? null;
        $factores = Factor::where('FK_FCT_Lineamiento', '=', $id_lineamiento)
            ->get()->pluck('nombre_factor', 'PK_FCT_Id');
        return view('autoevaluacion.SuperAdministrador.ReportesPlanMejoramiento.index',compact('factores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function obtenerDatos(Request $request)
    {
        //valorizacion de las caracteristicas
        $labels_caracteristicas = [];
        $data_caracteristicas = [];
        $data_factor = [];

        $caracteristicas = Caracteristica::whereHas('preguntas.respuestas.solucion.encuestados.encuesta', function ($query){
            return $query->where('FK_ECT_Proceso', '=', session()->get('id_proceso'));
        })
            ->where('FK_CRT_Factor', '=', '1')
            ->groupby('PK_CRT_Id')
            ->get();

        foreach ($caracteristicas as $caracteristica)
        {
            array_push($labels_caracteristicas, $caracteristica->CRT_Nombre);
            $soluciones = SolucionEncuesta::whereHas('encuestados.encuesta', function ($query){
                return $query->where('FK_ECT_Proceso', '=', session()->get('id_proceso'));
            })
            ->whereHas('respuestas.pregunta.caracteristica', function ($query) use ($caracteristica){
                return $query->where('PK_CRT_Id', '=', $caracteristica->PK_CRT_Id);
            })
            ->with('respuestas.ponderacion')
            ->get();
            $totalponderacion=0;
            $prueba = $soluciones->count();
            foreach($soluciones as $solucion)
            {
                $totalponderacion = $totalponderacion + (10/$solucion->respuestas->ponderacion->PRT_Rango);
            }
            $prueba = $totalponderacion/$prueba;
            array_push($data_caracteristicas, $prueba); 
        }
        $datos = [];
        $datos['labels_caracteristicas'] = $labels_caracteristicas;
        $datos['data_caracteristicas'] = array($data_caracteristicas);
        $datos['data_factor'] = array($data_factor);
        return json_encode($datos);
    }

    public function filtro_factores(Request $request)
    {
        /*filtro para obtener la valorizacion de las caracteristicas pertenecientes al factor digitado 
        por el usuario.
        */
        $labels_caracteristicas = [];
        $data_caracteristicas = [];
        $data_factor = [];


        $caracteristicas = Caracteristica::whereHas('preguntas.respuestas.solucion.encuestados.encuesta', function ($query){
            return $query->where('FK_ECT_Proceso', '=', session()->get('id_proceso'));
        })
            ->where('FK_CRT_Factor', '=', $request->get('PK_FCT_Id'))
            ->groupby('PK_CRT_Id')
            ->get();

        array_push($data_factor, Factor::where('PK_FCT_Id', $request->get('PK_FCT_Id'))->first()->FCT_Nombre);
        foreach ($caracteristicas as $caracteristica)
        {
            array_push($labels_caracteristicas, $caracteristica->CRT_Nombre);
            $soluciones = SolucionEncuesta::whereHas('encuestados.encuesta', function ($query){
                return $query->where('FK_ECT_Proceso', '=', session()->get('id_proceso'));
            })
            ->whereHas('respuestas.pregunta.caracteristica', function ($query) use ($caracteristica){
                return $query->where('PK_CRT_Id', '=', $caracteristica->PK_CRT_Id);
            })
            ->with('respuestas.ponderacion')
            ->get();
            $totalponderacion=0;
            $prueba = $soluciones->count();
            foreach($soluciones as $solucion)
            {
                $totalponderacion = $totalponderacion + (10/$solucion->respuestas->ponderacion->PRT_Rango);
            }
            $prueba = $totalponderacion/$prueba;
            array_push($data_caracteristicas, $prueba); 
        }
        $datos = [];
        $datos['labels_caracteristicas'] = $labels_caracteristicas;
        $datos['data_caracteristicas'] = array($data_caracteristicas);
        $datos['data_factor'] = array($data_factor);
        return json_encode($datos);

    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}