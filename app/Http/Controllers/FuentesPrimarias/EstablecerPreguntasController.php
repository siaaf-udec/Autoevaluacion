<?php

namespace App\Http\Controllers\FuentesPrimarias;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\PreguntaEncuesta;
use App\Models\DatosEncuesta;
use App\Models\Pregunta;
use App\Models\Proceso;
use App\Models\Encuesta;
use App\Models\Factor;
use App\Models\GrupoInteres;
use App\Http\Requests\EstablecerPreguntasRequest;

class EstablecerPreguntasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_ESTABLECER_PREGUNTAS');
        $this->middleware(['permission:MODIFICAR_ESTABLECER_PREGUNTAS', 'permission:VER_ESTABLECER_PREGUNTAS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_ESTABLECER_PREGUNTAS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_ESTABLECER_PREGUNTAS', ['only' => ['destroy']]);
    }
    public function index($id)
    {
        session()->put('id_encuesta', $id);
        return view('autoevaluacion.FuentesPrimarias.EstablecerPreguntas.index');
    }
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $preguntas = PreguntaEncuesta::with('preguntas','grupos')
            ->with('preguntas.estado')
            ->with('preguntas.tipo')
            ->with('preguntas.caracteristica')->
            where('FK_PEN_Encuesta',session()->get('id_encuesta'))->get();
            return DataTables::of($preguntas)
            ->removeColumn('created_at')
            ->removeColumn('updated_at')
            ->make(true);
        }
        return AjaxResponse::fail(
            '¡Lo sentimos!',
            'No se pudo completar tu solicitud.'
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id_proceso = Encuesta::where('PK_ECT_Id',session()->get('id_encuesta'))->first();
        $id_lineamiento = Proceso::where('PK_PCS_Id',$id_proceso->FK_ECT_Proceso)->first();
        $factores = Factor::where('FK_FCT_Lineamiento',$id_lineamiento->FK_PCS_Lineamiento)->get()->pluck('FCT_Nombre', 'PK_FCT_Id');
        $grupos = GrupoInteres::whereHas('estado', function($query){
            return $query->where('ESD_Valor','1');
        })->get();
        return view('autoevaluacion.FuentesPrimarias.EstablecerPreguntas.create', compact('factores','grupos'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(EstablecerPreguntasRequest $request)
    {
        $gruposInteres = $request->input('gruposInteres');
        if (is_array($gruposInteres)) {
            foreach ($gruposInteres as $key => $valor)
            {   
                if($valor !==  0)
                {
                    $verificar = PreguntaEncuesta::where('FK_PEN_Pregunta',$request->get('PK_PGT_Id'))
                    ->where('FK_PEN_Encuesta',$request->get('PK_ECT_Id'))
                    ->where('FK_PEN_GrupoInteres',$valor)
                    ->first();
                    if(!$verificar)
                    {
                        $preguntas_encuestas = new PreguntaEncuesta();
                        $preguntas_encuestas->FK_PEN_Pregunta = $request->get('PK_PGT_Id');
                        $preguntas_encuestas->FK_PEN_Encuesta = $request->get('PK_ECT_Id');
                        $preguntas_encuestas->FK_PEN_GrupoInteres = $valor;
                        $preguntas_encuestas->save();
                    }
                    else
                    {
                        $grupos = GrupoInteres::where('PK_GIT_Id',$valor)->first();
                        return response([
                            'errors' => ['La pregunta que selecciona ya existe para el grupo de interes de '.$grupos->GIT_Nombre],
                            'title' => '¡Error!'
                        ], 422) // 200 Status Code: Standard response for successful HTTP request
                        ->header('Content-Type', 'application/json');
                    }
                   
                }
            }
            return response(['msg' => 'Datos registrados correctamente.',
                'title' => '¡Registro exitoso!'
            ], 200) // 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
        }
        else
        {
            return response([
                'errors' => ['Seleccione como minimo un grupo de interes.'],
                'title' => '¡Error!'
            ], 422) // 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
        }
    
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
        PreguntaEncuesta::destroy($id);
        return response(['msg' => 'Los datos han sido eliminados exitosamente.',
                'title' => 'Datos Eliminados!'
            ], 200) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');
    }
}
