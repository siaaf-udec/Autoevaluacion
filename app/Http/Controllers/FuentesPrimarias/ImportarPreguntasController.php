<?php

namespace App\Http\Controllers\FuentesPrimarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportarPreguntasRequest;
use App\Models\Caracteristica;
use App\Models\Factor;
use App\Models\PonderacionRespuesta;
use App\Models\Pregunta;
use App\Models\Proceso;
use App\Models\RespuestaPregunta;
use App\Models\TipoRespuesta;
use Excel;
use Illuminate\Http\Request;

class ImportarPreguntasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:IMPORTAR_PREGUNTAS', ['only' => ['create', 'store']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('autoevaluacion.FuentesPrimarias.Preguntas.importar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImportarPreguntasRequest $request)
    {
        $archivo = $request->file('archivo');
        $results = "";
        if ($archivo) {
            try{
            Excel::selectSheets('TIPO', 'PONDERACION', 'PREGUNTA', 'RESPUESTA')->load($archivo->getRealPath(), function ($reader) {
                $sheets = $reader->all()->toArray();

                $tipo_respuesta = [];

                $count = count($sheets);
                if ($count <= 4 and $count > 0) {
                    //Tipo respesta
                    foreach ($sheets[0] as $row) {
                        $tipoRespuesta = new TipoRespuesta();
                        $tipoRespuesta->TRP_TotalPonderacion = $row['total_ponderacion'];
                        $tipoRespuesta->TRP_CantidadRespuestas = $row['cantidad_respuestas'];
                        $tipoRespuesta->TRP_Descripcion = $row['descripcion'];
                        $tipoRespuesta->FK_TRP_Estado = 1;
                        $tipoRespuesta->save();
                        $tipo_respuesta[$row['numero_tipo_respuesta']] = $tipoRespuesta->PK_TRP_Id;
                    }
                }
                if ($count <= 4 and $count > 1) {
                    //Ponderaciones
                    $ponderaciones = [];
                    foreach ($sheets[1] as $row) {
                        $ponderacion = new PonderacionRespuesta();
                        $ponderacion->PRT_Ponderacion = $row['ponderacion'];
                        $ponderacion->FK_PRT_TipoRespuestas = $tipo_respuesta[$row['tipo_respuesta']];
                        $ponderacion->save();
                        $ponderaciones[$row['numero_ponderacion']] = $ponderacion->PK_PRT_Id;
                    }
                }
                $lineamiento = Proceso::select('FK_PCS_Lineamiento')
                ->where('PK_PCS_Id', '=', session()
                ->get('id_proceso'))
                ->first();
                $caracteristicas = Caracteristica::whereHas('factor',function($query) use($lineamiento){
                    return $query->where('FK_FCT_Lineamiento',$lineamiento->FK_PCS_Lineamiento);
                })
                ->select('PK_CRT_Id', 'CRT_Identificador')
                ->get();

                if ($count <= 4 and $count > 3) {
                    //Preguntas
                    $preguntas = [];
                    foreach ($sheets[2] as $row) {
                        $pregunta = new Pregunta();
                        $pregunta->PGT_Texto = $row['pregunta'];
                        $pregunta->FK_PGT_Estado = 1;
                        $pregunta->FK_PGT_TipoRespuesta = $tipo_respuesta[$row['tipo_respuesta']];
                        $id = $caracteristicas->where('CRT_Identificador', $row['numero_caracteristica'])->first();
                        
                        $pregunta->FK_PGT_Caracteristica = $id->PK_CRT_Id;

                        $pregunta->save();
                        $preguntas[$row['numero_pregunta']] = $pregunta->PK_PGT_Id;
                    }
                }
                if ($count == 4) {
                    foreach ($sheets[3] as $row) {
                        $respuesta = new RespuestaPregunta();
                        $respuesta->RPG_Texto = $row['respuesta'];
                        $respuesta->FK_RPG_Pregunta = $preguntas[$row['numero_pregunta']];
                        $respuesta->FK_RPG_PonderacionRespuesta = $ponderaciones[$row['numero_ponderacion']];
                        $respuesta->save();
                    }
                }
            });
            }
            catch (\Exception $e) {
                return response(['errors' => [$e],
                    'title' => '¡Error!'
                ], 422) // 200 Status Code: Standard response for successful HTTP request
                    ->header('Content-Type', 'application/json');
            }
        }


        return response(['msg' => 'Preguntas registradas correctamente.',
            'title' => '¡Registro exitoso!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
