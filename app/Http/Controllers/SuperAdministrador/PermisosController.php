<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermisosRequest;
use DataTables;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class PermisosController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_PERMISOS');
        $this->middleware(['permission:MODIFICAR_PERMISOS', 'permission:VER_PERMISOS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_PERMISOS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_PERMISOS', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.Permisos.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            if (Gate::allows('SUPERADMINISTRADOR')) {
                $permisos = Permission::all();
                return Datatables::of($permisos)
                    ->make(true);
            } else {
                $permisos = Permission::all()
                    ->where('name', '!=', 'SUPERADMINISTRADOR')->where('name', '!=', 'ACCESO_MODULO_SUPERADMINISTRADOR')->where('name', '!=', 'ACCEDER_LINEAMIENTOS')->where('name', '!=', 'VER_LINEAMIENTOS')->where('name', '!=', 'CREAR_LINEAMIENTOS')->where('name', '!=', 'MODIFICAR_LINEAMIENTOS')->where('name', '!=', 'ELIMINAR_LINEAMIENTOS')
                    ->where('name', '!=', 'ACCEDER_ASPECTOS')->where('name', '!=', 'VER_ASPECTOS')->where('name', '!=', 'CREAR_ASPECTOS')->where('name', '!=', 'MODIFICAR_ASPECTOS')->where('name', '!=', 'ELIMINAR_ASPECTOS')
                    ->where('name', '!=', 'ACCEDER_SEDES')->where('name', '!=', 'MODIFICAR_FACULTADES')->where('name', '!=', 'VER_PROCESOS_INSTITUCIONALES')->where('name', '!=', 'ACCEDER_FACTORES')->where('name', '!=', 'MODIFICAR_CARACTERISTICAS')
                    ->where('name', '!=', 'VER_SEDES')->where('name', '!=', 'ELIMINAR_FACULTADES')->where('name', '!=', 'CREAR_PROCESOS_INSTITUCIONALES')->where('name', '!=', 'VER_FACTORES')->where('name', '!=', 'ELIMINAR_CARACTERISTICAS')
                    ->where('name', '!=', 'CREAR_SEDES')->where('name', '!=', 'ACCEDER_PROGRAMAS_ACADEMICOS')->where('name', '!=', 'MODIFICAR_PROCESOS_INSTITUCIONALES')->where('name', '!=', 'CREAR_FACTORES')->where('name', '!=', 'ACCEDER_AMBITOS')
                    ->where('name', '!=', 'MODIFICAR_SEDES')->where('name', '!=', 'VER_PROGRAMAS_ACADEMICOS')->where('name', '!=', 'ELIMINAR_PROCESOS_INSTITUCIONALES')->where('name', '!=', 'MODIFICAR_FACTORES')->where('name', '!=', 'VER_AMBITOS')
                    ->where('name', '!=', 'ELIMINAR_SEDES')->where('name', '!=', 'CREAR_PROGRAMAS_ACADEMICOS')->where('name', '!=', 'ACCEDER_LINEAMIENTOS')->where('name', '!=', 'ELIMINAR_FACTORES')->where('name', '!=', 'CREAR_AMBITOS')
                    ->where('name', '!=', 'ACCEDER_FACULTADES')->where('name', '!=', 'MODIFICAR_PROGRAMAS_ACADEMICOS')->where('name', '!=', 'ACCEDER_LINEAMIENTOS')->where('name', '!=', 'ACCEDER_CARACTERISTICAS')->where('name', '!=', 'MODIFICAR_AMBITOS')
                    ->where('name', '!=', 'VER_FACULTADES')->where('name', '!=', 'ELIMINAR_PROGRAMAS_ACADEMICOS')->where('name', '!=', 'ACCEDER_LINEAMIENTOS')->where('name', '!=', 'VER_CARACTERISTICAS')->where('name', '!=', 'ELIMINAR_AMBITOS')
                    ->where('name', '!=', 'CREAR_FACULTADES')->where('name', '!=', 'ACCEDER_PROCESOS_INSTITUCIONALES')->where('name', '!=', 'ACCEDER_LINEAMIENTOS')->where('name', '!=', 'CREAR_CARACTERISTICAS');
                return Datatables::of($permisos)
                    ->make(true);
            }
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermisosRequest $request)
    {
        $rol = Permission::create($request->all());


        return response(['msg' => 'Permiso registrado correctamente.',
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermisosRequest $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->update($request->all());


        return response(['msg' => 'El Permiso ha sido modificado exitosamente.',
            'title' => 'Permiso Modificado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();


        return response(['msg' => 'El Permiso ha sido eliminado exitosamente.',
            'title' => '¡Permiso Eliminado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
