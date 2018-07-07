<?php

namespace App\Http\Controllers\FuentesPrimarias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Factor;
use App\Models\Lineamiento;
use App\Models\Estado;
use App\Models\Pregunta;
use App\Models\Caracteristica;
use App\Models\TipoRespuesta;
use App\Models\RespuestaPregunta;
use DataTables;
use App\Http\Requests\PreguntasRequest;

class PreguntasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_PREGUNTAS');
        $this->middleware(['permission:MODIFICAR_PREGUNTAS', 'permission:VER_PREGUNTAS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_PREGUNTAS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_PREGUNTAS', ['only' => ['destroy']]);
    }
    public function index()
    {
        return view('autoevaluacion.FuentesPrimarias.Preguntas.index');

    }

    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $preguntas = Pregunta::with('estado','tipo','caracteristica')->get();
            return DataTables::of($preguntas)
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
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        $tipos = TipoRespuesta::pluck('TRP_CantidadRespuestas','PK_TRP_Id');
        return view('autoevaluacion.FuentesPrimarias.Preguntas.create', compact('estados','lineamientos','tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PreguntasRequest $request)
    {
        $pregunta = new Pregunta();
        $pregunta->fill($request->only(['PGT_Texto']));
        $pregunta->FK_PGT_Estado = $request->get('PK_ESD_Id');
        $pregunta->FK_PGT_TipoRespuesta = $request->get('PK_TRP_Id');
        $pregunta->FK_PGT_Caracteristica = $request->get('PK_CRT_Id');
        $pregunta->save();
        $insertedId = $pregunta->PK_PGT_Id;
        $tipos = TipoRespuesta::select('TRP_CantidadRespuestas')->where('PK_TRP_Id', $request->get('PK_TRP_Id'))->first();
        $cantidad =  $tipos->TRP_CantidadRespuestas;
        for($i=1;$i<=$cantidad;$i++){
            $respuestas = new RespuestaPregunta();
            $respuestas->RPG_Texto = $request->get('Respuesta_'.$i);
            $respuestas->FK_RPG_Pregunta = $insertedId;
            $respuestas->FK_RPG_PonderacionRespuesta = $request->get('Ponderacion_'.$i);
            $respuestas->save();
        }

        return response(['msg' => 'Pregunta registrada correctamente.',
        'title' => '¡Registro exitoso!'
    ], 200) // 200 Status Code: Standard response for successful HTTP request
          ->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pregunta = Pregunta::where('FK_PGT_Caracteristica',$id)->pluck('PGT_Texto','PK_PGT_Id');
        return json_encode($pregunta);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pregunta = Pregunta::findOrFail($id);

        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $lineamientos =  Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        $respuestas = RespuestaPregunta::where('FK_RPG_Pregunta', $id)->get();
        $factor = new Factor();
        $id_factor = $pregunta->caracteristica->factor->lineamiento()->pluck('PK_LNM_Id')[0];
        $factores = $factor->where('FK_FCT_Lineamiento', $id_factor)->get()->pluck('FCT_Nombre', 'PK_FCT_Id');
        $caracteristica = new Caracteristica();
        $id_caracteristica = $pregunta->caracteristica->factor()->pluck('PK_FCT_Id')[0];
        $caracteristicas = $caracteristica->where('FK_CRT_Factor', $id_caracteristica)->get()->pluck('CRT_Nombre', 'PK_CRT_Id');
        return view('autoevaluacion.FuentesPrimarias.Preguntas.edit',
            compact('pregunta', 'estados', 'factores', 'caracteristicas','respuestas','lineamientos')
            );
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
        $pregunta = Pregunta::find($id);
        $pregunta->fill($request->only(['PGT_Texto']));
        $pregunta->FK_PGT_Estado = $request->get('PK_ESD_Id');
        $pregunta->FK_PGT_Caracteristica = $request->get('PK_CRT_Id');
        $pregunta->update();
        
        $respuestas = RespuestaPregunta::where('FK_RPG_Pregunta', $id)->get();
        foreach ($respuestas as $respuesta){
            $rpta = RespuestaPregunta::find($respuesta->PK_RPG_Id);
            $rpta->RPG_Texto = $request->get($respuesta->PK_RPG_Id);
            $rpta->FK_RPG_Pregunta = $id;
            $rpta->FK_RPG_PonderacionRespuesta = $respuesta->FK_RPG_PonderacionRespuesta;
            $rpta->update();
        }
        
        return response(['msg' => 'La pregunta ha sido modificada exitosamente.',
                'title' => '¡Pregunta Modificada!'
            ], 200) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pregunta::destroy($id);

        return response(['msg' => 'La pregunta ha sido eliminada exitosamente.',
                'title' => '¡Pregunta Eliminada!'
            ], 200) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function caracteristicas($id)
    {
        $caracteristicas = Caracteristica::where('FK_CRT_Factor', $id)->pluck('CRT_Nombre', 'PK_CRT_Id');
        return json_encode($caracteristicas);
    }
    
}
