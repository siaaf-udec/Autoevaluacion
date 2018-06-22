<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\Factor;
use App\Models\Estado;
use App\Models\Lineamiento;

class FactorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware([
            'permission:CREAR_FACTORES',
            'permission:VER_FACTORES',
            'permission:MODIFICAR_FACTORES',
            'permission:ELIMINAR_FACTORES'
            ]);

    }
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $factores = Factor::with(['estado' => function ($query) {
            return $query->select('PK_ESD_Id','ESD_Nombre as nombre_estado');
        }])
        ->with(['lineamiento' => function ($query) {
            return $query->select('PK_LNM_Id',
                'LNM_Nombre as nombre');
        }])->get();
            return Datatables::of($factores)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.Factor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        return view('autoevaluacion.SuperAdministrador.Factor.create', compact('estados','lineamientos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Factor::create($request->all());
        return response(['msg' => 'Factor registrado correctamente.',
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
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        return view('autoevaluacion.SuperAdministrador.Factor.edit', [
            'user' => Factor::findOrFail($id),
            'edit' => true,
        ], compact('estados','lineamientos'));
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
        $user = Factor::find($id);
        $user->fill($request->all());
        $user->save();
        return response(['msg' => 'EL factor ha sido modificado exitosamente.',
                'title' => 'Factor Modificado!'
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
        Factor::destroy($id);

            return response(['msg' => 'El factor ha sido eliminado exitosamente.',
                'title' => 'Factor Eliminado!'
            ], 200) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');
    }
}
