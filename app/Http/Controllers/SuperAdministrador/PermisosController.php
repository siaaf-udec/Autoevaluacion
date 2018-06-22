<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use DataTables;
use App\Http\Requests\PermisosRequest;



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
        $this->middleware(['permission:MODIFICAR_PERMISOS', 'permission:VER_USUARIOS'], ['only' => ['edit', 'update']]);
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
            $permisos = Permission::all();
            return Datatables::of($permisos)
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
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermisosRequest $request)
    {
        $rol = Permission::create($request->all());


        return response(['msg' => 'Permiso registrado correctamente.',
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermisosRequest $request, $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->update($request->all());


        return response(['msg' => 'El Permiso ha sido modificado exitosamente.',
                'title' => 'Permiso Modificado!'
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
        $permission = Permission::findOrFail($id);
        $permission->delete();


        return response(['msg' => 'El Permiso ha sido eliminado exitosamente.',
                'title' => '¡Permiso Eliminado!'
            ], 200) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');
    }
}
