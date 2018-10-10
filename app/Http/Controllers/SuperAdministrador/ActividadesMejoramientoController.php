<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\ActividadesMejoramiento;
use App\Models\Autoevaluacion\SolucionEncuesta;
use App\Models\Autoevaluacion\PlanMejoramiento;
use App\Models\Autoevaluacion\Encuesta;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\Lineamiento;
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
        $planMejoramiento = PlanMejoramiento::where('FK_PDM_Proceso','=',session()->get('id_proceso'))
        ->first();
        if($planMejoramiento!=null){
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
                    $caracteristicas = Caracteristica::whereHas('preguntas.respuestas.solucion.encuestados.encuesta', function ($query){
                        return $query->where('FK_ECT_Proceso', '=', session()->get('id_proceso'));
                    })
                    ->where('PK_CRT_Id','=',$actividades->Caracteristicas->PK_CRT_Id)
                    ->groupby('PK_CRT_Id')
                    ->get();
        
                    foreach ($caracteristicas as $caracteristica)
                    {
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
                        return $totalponderacion/$prueba;
                    }
                })
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->make(true);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        session()->put('id_actividad', $id);
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        return view('autoevaluacion.SuperAdministrador.ActividadesMejoramiento.create',compact('lineamientos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $actividades = new ActividadesMejoramiento();
        /**
        * Se debe cambiar el formato de la fecha de publicacion y de finalizacion.  
        */
        $actividades->fill($request->only(['ACM_Nombre', 'ACM_Descripcion']));
        $actividades->ACM_Fecha_Inicio = Carbon::createFromFormat('d/m/Y', $request->get('ACM_Fecha_Inicio'));;
        $actividades->ACM_Fecha_Fin = Carbon::createFromFormat('d/m/Y', $request->get('ACM_Fecha_Fin'));
        $actividades->FK_ACM_Caracteristica = session()->get('id_actividad');
        $idPlanMejoramiento = PlanMejoramiento::where('FK_PDM_Proceso','=', session()->get('id_proceso'))->first()->PK_PDM_Id;
        $actividades->FK_ACM_Plan_Mejoramiento = $idPlanMejoramiento;
        $actividades->save();
        return response([
            'msg' => 'Actividad creada con exito.',
            'title' => '¡Proceso Exitoso!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
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
        $actividades = ActividadesMejoramiento::findOrFail($id);
        return view(
            'autoevaluacion.SuperAdministrador.ActividadesMejoramiento.edit',
            compact('actividades')
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
        $actividades = ActividadesMejoramiento::find($id);
        $actividades->ACM_Fecha_Inicio = Carbon::createFromFormat('d/m/Y', $request->get('ACM_Fecha_Inicio'));;
        $actividades->ACM_Fecha_Fin = Carbon::createFromFormat('d/m/Y', $request->get('ACM_Fecha_Fin'));
        
        $actividades->ACM_Nombre = $request->get('ACM_Nombre');
        $actividades->ACM_Descripcion = $request->get('ACM_Descripcion');
        $actividades->update();
        return response(['msg' => 'La actividad de mejoramiento de ha moficado.',
            'title' => 'Actividad de Mejoramiento Modificada!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
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
        ActividadesMejoramiento::destroy($id);

        return response(['msg' => 'La actividad de mejoramiento se ha sido eliminada exitosamente.',
            'title' => 'Actividad de Mejoramiento Eliminada!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
