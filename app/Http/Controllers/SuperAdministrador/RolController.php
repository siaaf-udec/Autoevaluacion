<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\RolRequest;
use DataTables;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RolController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_ROLES');
        $this->middleware(['permission:MODIFICAR_ROLES', 'permission:VER_ROLES'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_ROLES', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_ROLES', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.Roles.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $roles = Role::all();
            return Datatables::of($roles)
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
        $permisos = Permission::pluck('name', 'name');

        return view('autoevaluacion.SuperAdministrador.Roles.create', compact('permisos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolRequest $request)
    {
        $rol = Role::create($request->except('permission'));
        $permisos = $request->input('permission') ? $request->input('permission') : [];
        $rol->givePermissionTo($permisos);


        return response(['msg' => 'Rol registrado correctamente.',
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
        $permisos = Permission::pluck('name', 'name');

        $rol = Role::findOrFail($id);

        $edit = true;

        return view('autoevaluacion.SuperAdministrador.Roles.edit',
            compact('rol', 'permisos', 'edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(RolRequest $request, $id)
    {
        $rol = Role::findOrFail($id);
        $rol->update($request->except('permission'));
        $permisos = $request->input('permission') ? $request->input('permission') : [];
        $rol->syncPermissions($permisos);


        return response(['msg' => 'El Rol ha sido modificado exitosamente.',
            'title' => 'Rol Modificado!'
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
        $rol = Role::findOrFail($id);
        $rol->delete();

        return response(['msg' => 'El Rol ha sido eliminado exitosamente.',
            'title' => '¡Rol Eliminado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
