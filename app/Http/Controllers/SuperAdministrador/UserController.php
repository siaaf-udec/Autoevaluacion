<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Estado;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PerfilUsuarioRequest;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_USUARIOS', ['except' => ['perfil', 'modificarPerfil']]);
        $this->middleware(['permission:MODIFICAR_USUARIOS', 'permission:VER_USUARIOS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_USUARIOS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_USUARIOS', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.Users.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if (Gate::allows('SUPERADMINISTRADOR')){
            if ($request->ajax() && $request->isMethod('GET')) {
                $users = User::with('estado', 'roles')
                ->where('id','!=',Auth::id())->get();
                return DataTables::of($users)
                    ->addColumn('estado', function ($users) {
                        if (!$users->estado) {
                            return '';
                        } elseif (!strcmp($users->estado->ESD_Nombre, 'HABILITADO')) {
                            return "<span class='label label-sm label-success'>" . $users->estado->ESD_Nombre . "</span>";
                        } else {
                            return "<span class='label label-sm label-danger'>" . $users->estado->ESD_Nombre . "</span>";
                        }
                        return "<span class='label label-sm label-primary'>" . $users->estado->ESD_Nombre . "</span>";
                    })
                    ->addColumn('roles', function ($users) {
                        if (!$users->roles) {
                            return '';
                        }
                        return $users->roles->map(function ($rol) {
                            return str_limit($rol->name, 30, '...');
                        })->implode(', ');
                    })
                    ->rawColumns(['estado'])
                    ->removeColumn('cedula')
                    ->removeColumn('created_at')
                    ->removeColumn('updated_at')
                    ->removeColumn('id_estado')
                    ->make(true);
            }
    }
    else{
        if ($request->ajax() && $request->isMethod('GET')) {
            $users = User::with('estado', 'roles')
            ->where('id','!=',Auth::id())
            ->where('id_programa','=',Auth::user()->id_programa)->get();
            return DataTables::of($users)
                ->addColumn('estado', function ($users) {
                    if (!$users->estado) {
                        return '';
                    } elseif (!strcmp($users->estado->ESD_Nombre, 'HABILITADO')) {
                        return "<span class='label label-sm label-success'>" . $users->estado->ESD_Nombre . "</span>";
                    } else {
                        return "<span class='label label-sm label-danger'>" . $users->estado->ESD_Nombre . "</span>";
                    }
                    return "<span class='label label-sm label-primary'>" . $users->estado->ESD_Nombre . "</span>";
                })
                ->addColumn('roles', function ($users) {
                    if (!$users->roles) {
                        return '';
                    }
                    return $users->roles->map(function ($rol) {
                        return str_limit($rol->name, 30, '...');
                    })->implode(', ');
                })
                ->rawColumns(['estado'])
                ->removeColumn('cedula')
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->removeColumn('id_estado')
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
        if (Gate::allows('SUPERADMINISTRADOR')){

            $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
            $roles = Role::pluck('name', 'name');
            return view('autoevaluacion.SuperAdministrador.Users.create', compact('estados', 'roles'));

        }
        else{

            $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
            $roles = Role::where('name', '!=', 'SUPERADMIN')
                           ->where('name', '!=', 'ADMIN')
                           ->pluck('name', 'name');
            return view('autoevaluacion.SuperAdministrador.Users.create', compact('estados', 'roles'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->fill($request->all());
        $user->id_estado = $request->get('PK_ESD_Id');
        $user->save();

        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->assignRole($roles);

        return response(['msg' => 'Usuario registrado correctamente.',
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
        if (Gate::allows('SUPERADMINISTRADOR')){

            $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
            $roles = Role::pluck('name', 'name');
            $user = User::findOrFail($id);
            $edit = true;
            return view(
                'autoevaluacion.SuperAdministrador.Users.edit',
                compact('user', 'estados', 'roles', 'edit')
            );
        }
        else{

            $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $roles = Role::where('name', '!=', 'SUPERADMIN')->where('name', '!=', 'ADMIN')->pluck('name', 'name');
        $user = User::findOrFail($id);
        $edit = true;
        return view(
            'autoevaluacion.SuperAdministrador.Users.edit',
            compact('user', 'estados', 'roles', 'edit')
        );

    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        $user->fill($request->except('password'));

        if ($request->get('password')) {
            $user->password = $request->get('password');
        }

        $user->id_estado = $request->get('PK_ESD_Id');

        $user->update();

        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->syncRoles($roles);

        return response(['msg' => 'El usuario ha sido modificado exitosamente.',
            'title' => '¡Usuario Modificado!'
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
        User::destroy($id);

        return response(['msg' => 'El usuario se ha sido eliminado exitosamente.',
            'title' => '¡Usuario Eliminado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

    public function perfil(){
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $roles = Role::pluck('name', 'name');
        $user = User::findOrFail(Auth::id());
        $edit = true;
        return view(
            'autoevaluacion.SuperAdministrador.Users.perfil',
            compact('user', 'estados', 'roles', 'edit')
        );
    }

    public function modificarPerfil(PerfilUsuarioRequest $request)
    {
        $user = User::find(Auth::id());
        $user->fill($request->except('password'));

        if($request->get('password')){
            $user->password = $request->get('password');
        }

        if($request->get('PK_ESD_Id')){
            $user->id_estado = $request->get('PK_ESD_Id')?$request->get('PK_ESD_Id'):null;
        }
        $user->update();

        if($request->input('roles')){
            $roles = $request->input('roles') ? $request->input('roles') : [];
            $user->syncRoles($roles);
        }

        return response(['msg' => 'El usuario se ha sido modificado exitosamente.',
            'title' => '¡Usuario Modificado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');


    }
}
