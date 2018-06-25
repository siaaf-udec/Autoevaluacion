<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Caracteristica;
use App\Models\Factor;
use App\Models\Estado;
use App\Models\AmbitoResponsabilidad;
use App\Models\Lineamiento;
use Yajra\Datatables\Datatables;

class CaracteristicasController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return void \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware([
            'permission:CREAR_CARACTERISTICAS',
            'permission:VER_CARACTERISTICAS' 
            ]);

    }
    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.Caracteristicas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $caracteristica = Caracteristica::with(['estado' => function ($query) {
            return $query->select('PK_ESD_Id','ESD_Nombre as nombre_estado');
        }])
        ->with(['ambitoresponsabilidad' => function ($query) {
            return $query->select('PK_AMB_Id',
                'AMB_Nombre as nombre');
        }])->with(['factor' => function ($query) {
            return $query->select('PK_FCT_Id',
                'FCT_Nombre as nombre_factor');
        }])
        ->get();
            return Datatables::of($caracteristica)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->addIndexColumn()
                ->make(true);

        }
    }
    public function create()
    {

        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $ambitos = AmbitoResponsabilidad::pluck('AMB_Nombre', 'PK_AMB_Id');
        return view('autoevaluacion.SuperAdministrador.Caracteristicas.create', compact('lineamientos','estados','ambitos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Caracteristica::create($request->except('FK_FCT_Lineamiento'));
        return response(['msg' => 'Datos registrados correctamente.',
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
        $caracteristicas = Caracteristica::where('FK_CRT_Factor', $id)->pluck('CRT_Nombre', 'PK_CRT_Id');
        return json_encode($caracteristicas);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $ambitos = AmbitoResponsabilidad::pluck('AMB_Nombre', 'PK_AMB_Id');
        return view('autoevaluacion.SuperAdministrador.Caracteristicas.edit', [
            'user' => Caracteristica::findOrFail($id),
            'edit' => true,
        ], compact('lineamientos','estados','ambitos'));
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
        
        $caracteristica = Caracteristica::find($id);
        $caracteristica->fill($request->except('FK_FCT_Lineamiento'));
        $caracteristica->save();
        return response(['msg' => 'Los datos han sido modificado exitosamente.',
                'title' => 'Datos Modificadoa!'
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
        Caracteristica::destroy($id);

            return response(['msg' => 'Los datos han sido eliminados exitosamente.',
                'title' => 'Datos Eliminados!'
            ], 200) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');
    }
    public function factores($id)
    {
        $factores = Factor::where('FK_FCT_Lineamiento',$id)->pluck('FCT_Nombre','PK_FCT_Id');
        return json_encode($factores);
    }
}

