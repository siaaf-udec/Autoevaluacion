<?php

namespace App\Http\Controllers\FuentesPrimarias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\PreguntaEncuesta;
use App\Models\Pregunta;
use App\Models\Factor;
use App\Models\GrupoInteres;


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
            $preguntas = PreguntaEncuesta::with('preguntas')
            ->with('preguntas.estado')
            ->with('preguntas.tipo')
            ->with('preguntas.caracteristica')->get();
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
        $factores = Factor::where('FK_FCT_Lineamiento',session()->get('id_proceso'))->get()->pluck('FCT_Nombre', 'PK_FCT_Id');
        $grupos = GrupoInteres::whereHas('estado', function($query){
            return $query->where('ESD_Valor','1');
        })->get();
        return view('autoevaluacion.FuentesPrimarias.EstablecerPreguntas.create', compact('factores','grupos'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $checks = $request->input('check');
        foreach ($checks as $key => $value)
        {
            if($value !==  0)
            {
                $preguntas_encuestas = new PreguntaEncuesta();
                $preguntas_encuestas->FK_PEN_Pregunta = $request->get('PK_PGT_Id');
                $preguntas_encuestas->FK_PEN_Encuesta = session()->get('id_encuesta');
                $preguntas_encuestas->FK_PEN_GrupoInteres = $value;
                $preguntas_encuestas->save();
            }
        }
        return response(['msg' => 'Datos registrados correctamente.',
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
