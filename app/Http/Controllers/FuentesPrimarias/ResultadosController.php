<?php

namespace App\Http\Controllers\FuentesPrimarias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\Encuesta;
use App\Models\Autoevaluacion\Encuestado;
use App\Models\Autoevaluacion\PreguntaEncuesta;
use App\Models\Autoevaluacion\SolucionEncuesta;
use App\Models\Autoevaluacion\RespuestaPregunta;
use DataTables;

class ResultadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.FuentesPrimarias.Resultados.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $encuesta = Encuesta::where('FK_ECT_Proceso', '=', session()->get('id_proceso'))
            ->first();
            $respuestas = RespuestaPregunta::whereHas('pregunta.preguntas_encuesta', function ($query) use($encuesta) {
                return $query->where('FK_PEN_Banco_Encuestas', '=',$encuesta->FK_ECT_Banco_Encuestas ?? null);
            })
            ->with('pregunta.preguntas_encuesta.grupos')
            ->with(['solucion' => function($query){
                $query->selectRaw('*,COUNT(FK_SEC_Respuesta) as cantidad')
                ->groupby('FK_SEC_Respuesta');
            }])
            ->get();

            return DataTables::of($respuestas)
            ->addColumn('Grupo', function ($respuestas) {
                foreach($respuestas->pregunta->preguntas_encuesta as $respuesta)
                {
                    return $respuesta->grupos->GIT_Nombre;
                }
            })
            ->addColumn('Encuestados', function ($respuestas) {
                foreach($respuestas->solucion as $solucion)
                {
                    return $solucion->cantidad;                    
                }
            })
            ->removeColumn('created_at')
            ->removeColumn('updated_at')
            ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
