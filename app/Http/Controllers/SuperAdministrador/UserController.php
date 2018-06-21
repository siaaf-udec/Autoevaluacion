<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

use App\Models\User;

use App\Http\Requests\UserRequest;
use App\Models\Estado;

class UserController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware([
            'permission:CREAR_USUARIOS',
            'permission:VER_USUARIOS' 
            ]);

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
        if ($request->ajax() && $request->isMethod('GET')) {
            $usuarios = User::all();
            return Datatables::of($usuarios)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->addIndexColumn()
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
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        return view('autoevaluacion.SuperAdministrador.Users.create', compact('estados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = new User();
        $user->fill($request->all());
        $user->id_estado = $request->get('PK_ESD_Id');
        $user->save();

        return response(['msg' => 'Usuario registrado correctamente.',
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
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');


        return view('autoevaluacion.SuperAdministrador.Users.edit', [
            'user' => User::findOrFail($id),
            'edit' => true,
            'estados' => $estados 
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        $user->fill($request->all());
        $user->id_estado = $request->get('PK_ESD_Id');

        $user->save();
        return response(['msg' => 'El usuario ha sido modificado exitosamente.',
                'title' => '¡Usuario Modificado!'
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
       
            User::destroy($id);

            return response(['msg' => 'El usuario ha sido eliminado exitosamente.',
                'title' => '¡Usuario Eliminado!'
            ], 200) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');

        
    }
}
