<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProcesoUsuarioController extends Controller
{
     /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_PROCESOS_INSTITUCIONALES');
        $this->middleware(['permission:MODIFICAR_PROCESOS_INSTITUCIONALES', 'permission:VER_PROCESOS_INSTITUCIONALES'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_PROCESOS_INSTITUCIONALES', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_PROCESOS_INSTITUCIONALES', ['only' => ['destroy']]);
    }
    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {

            $procesos_programas = Proceso::with(['fase' => function ($query) {
                return $query->select('PK_FSS_Id', 'FSS_Nombre');
            }])
             ->with(['lineamiento' => function ($query) {
                    return $query->select('PK_LNM_Id', 'LNM_Nombre');
                }])
                ->where('PCS_Institucional', '=', '1')
                ->get();

            return DataTables::of($procesos_programas)
                ->editColumn('PCS_FechaInicio', function ($proceso_programa) {
                    return $proceso_programa->PCS_FechaInicio ? with(new Carbon($proceso_programa->PCS_FechaInicio))->format('d/m/Y') : '';
                })
                ->editColumn('PCS_FechaFin', function ($proceso_programa) {
                    return $proceso_programa->PCS_FechaFin ? with(new Carbon($proceso_programa->PCS_FechaFin))->format('d/m/Y') : '';
                    ;
                })
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->make(true);
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
    }
    /**
     * asignar usuarios a procesos
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function asignarUsuarios(Request $request)
    {
        

            return response([
                'msg' => 'Proceso registrado correctamente.',
                'title' => '¡Registro exitoso!'
            ], 200)// 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
       
    }

    /**
     * desasignar usuarios de procesos
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function desasignarUsuarios(Request $request)
    {
        
        return response([
                'errors' => ['La fecha de inicio tiene que ser menor que la fecha de terminación del proceso.'],
                'title' => '¡Error!'
            ], 422)// 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
    }
}
