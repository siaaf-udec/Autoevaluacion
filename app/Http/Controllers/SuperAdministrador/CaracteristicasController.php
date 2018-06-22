<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Caracteristica;
use App\Models\Factor;
use App\Models\Estado;
use App\Models\Ambito;
use App\Models\Lineamiento;


class CaracteristicasController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return void \Illuminate\Http\Response
     */

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
            $caracteristicas = Caracteristica::select('PK_CRT_Id','CRT_Nombre','CRT_Descripcion',
            'FK_CRT_Factor')->with(['factor' => function($query){
                return $query->select('PK_FCT_Id','FCT_Nombre as nombre');
            }
        ])->get();
            return Datatables::of($caracteristicas)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->addIndexColumn()
                ->make(true);
        }
        dd($datosEncuesta);
        return AjaxResponse::fail(
            '¡Lo sentimos mmmm!',
            'No se pudo completar tu solicitud.'
        );

    }
    public function create()
    {
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        $factores = Factor::where('FK_FCT_Lineamiento',$id)->pluck('FCT_Nombre','PK_FCT_Id');
        return view('autoevaluacion.SuperAdministrador.Caracteristicas.create', compact('lineamientos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Caracteristica::create($request->all());
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
        $items = Factor::pluck('FCT_Nombre', 'PK_FCT_Id');
        return view('autoevaluacion.SuperAdministrador.Caracteristicas.edit', [
            'user' => Caracteristica::findOrFail($id),
            'edit' => true,
        ], compact('items'));
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
        $user = Caracteristica::find($id);
        $user->fill($request->all());
        $user->save();
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
    public function lineamientos()
    {
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
    }
    public function factores($id)
    {
        $factores = Factor::where('FK_FCT_Lineamiento',$id)->pluck('FCT_Nombre','PK_FCT_Id');
    }
}

