<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use DataTables;
use App\Models\Proceso;

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
    public function data(Request $request, $id)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $usuarios = User::with('procesos')->get();

            return DataTables::of($usuarios)
                ->addColumn('seleccion',function($usuario) use($id){
                    $checked = '';
                    foreach ($usuario->procesos as $proceso) {
                        if($proceso->PK_PCS_Id == $id){
                            $checked = 'checked';
                            break;
                        }
                    }
                    return '<input type="checkbox" class="ids_usuarios" name="seleccion" value="'.$usuario->id.'" '.$checked.' />';
                })
                ->rawColumns(['seleccion'])
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
        $proceso = Proceso::findOrFail($id);
        $tipo = 'Programa ';
        if($proceso->PCS_Institucional == 1){
            $tipo = 'Institucion ';
        }
        $proceso = $tipo . $proceso->PCS_Nombre;
        $proceso = str_limit($proceso, 45, '...');


        return view('autoevaluacion.SuperAdministrador.ProcesosUsuarios.index', compact('proceso'));
    }
    /**
     * asignar usuarios a procesos
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function asignarUsuarios(Request $request, $id)
    {
        $proceso = Proceso::findOrFail($id);
        $proceso->users()->sync($request->get('usuarios'));

            return response([
                'msg' => 'Proceso asignado correctamente.',
                'title' => '¡Asignacion exitosa exitoso!'
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