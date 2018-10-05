<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\ActividadesMejoramiento;
use App\Models\Autoevaluacion\Encuesta;
use App\Models\Autoevaluacion\Caracteristica;
use DataTables;
use Carbon\Carbon;

class ActividadesMejoramientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicación como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_ACTIVIDADES_MEJORAMIENTO')->except('show');
        $this->middleware(['permission:MODIFICAR_ACTIVIDADES_MEJORAMIENTO', 'permission:VER_ACTIVIDADES_MEJORAMIENTO'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_ACTIVIDADES_MEJORAMIENTO', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_ACTIVIDADES_MEJORAMIENTO', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.ActividadesMejoramiento.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $actividades = ActividadesMejoramiento::whereHas('PlanMejoramiento', function ($query) {
                return $query->where('FK_PDM_Proceso', '=', session()->get('id_proceso') );
            })
            ->with('Caracteristicas')
            ->get();
            return DataTables::of($actividades)
            ->editColumn('ACM_Fecha_Inicio', function ($actividades) {
                return $actividades->ACM_Fecha_Inicio ? with(new Carbon($actividades->ACM_Fecha_Inicio))->format('d/m/Y') : '';
            })
            ->editColumn('ACM_Fecha_Fin', function ($actividades) {
                return $actividades->ACM_Fecha_Fin ? with(new Carbon($actividades->ACM_Fecha_Fin))->format('d/m/Y') : '';
            })
            ->addColumn('Valorizacion', function ($actividades) {
                $encuesta = Encuesta::where('FK_ECT_Proceso', '=', session()->get('id_proceso'))
                ->first();
                $caracteristicas = Caracteristica::whereHas('preguntas.respuestas.solucion.encuestados', function ($query) use ($encuesta) {
                return $query->where('FK_ECD_Encuesta', '=', $encuesta->PK_ECT_Id ?? null);
                })
                ->with('preguntas')
                ->where('PK_CRT_Id','=',$actividades->Caracteristicas->PK_CRT_Id)
                ->where('FK_CRT_Factor', '=', '1')
                ->groupby('PK_CRT_Id')
                ->get();
                $totalponderacion = 0.0;
                foreach ($caracteristicas as $caracteristica) {
                    foreach ($caracteristica->preguntas as $pregunta) {
                        $respuestas = SolucionEncuesta::whereHas('respuestas.ponderacion', function ($query) use ($pregunta) {
                        return $query->where('FK_RPG_Pregunta', '=', $pregunta->PK_PGT_Id);
                    })
                    ->with('respuestas.ponderacion')
                    ->get();
                    $totalponderacion = 0.0;
                        foreach ($respuestas as $respuesta) {
                            $totalponderacion = $totalponderacion + $respuesta->respuestas->ponderacion->PRT_Ponderacion;
                        }
                    }
                }
                return $totalponderacion;
            })
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
