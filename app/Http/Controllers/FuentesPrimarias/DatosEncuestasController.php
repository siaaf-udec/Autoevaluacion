<?php

namespace App\Http\Controllers\FuentesPrimarias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Http\Requests\DatosEncuestasRequest;
use App\Models\DatosEncuesta;
use App\Models\GrupoInteres;

class DatosEncuestasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_ENCUESTAS');
        $this->middleware(['permission:MODIFICAR_ENCUESTAS', 'permission:VER_ENCUESTAS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_ENCUESTAS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_ENCUESTAS', ['only' => ['destroy']]);
    }
    public function index()
    {
        return view('autoevaluacion.FuentesPrimarias.DatosEncuestas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $datosEncuesta = DatosEncuesta::with('grupos')->get();
            return Datatables::of($datosEncuesta)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->addIndexColumn()
                ->make(true);
        }
        dd($datosEncuesta);
        return AjaxResponse::fail(
            '¡Lo sentimos!',
            'No se pudo completar tu solicitud.'
        );

    }
    public function create()
    {
        $grupos = GrupoInteres::whereHas('estado', function($query){
            return $query->where('ESD_Valor','1');
        })->get()->pluck('GIT_Nombre', 'PK_GIT_Id');
        return view('autoevaluacion.FuentesPrimarias.DatosEncuestas.create', compact('grupos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DatosEncuestasRequest $request)
    {
        $datos_encuesta = new DatosEncuesta();
        $datos_encuesta->fill($request->only(['DAE_Titulo', 'DAE_Descripcion']));
        $datos_encuesta->FK_DAE_GruposInteres = $request->get('PK_GIT_Id');
        $datos_encuesta->save();
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
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datos = DatosEncuesta::findOrFail($id);
        $grupos = GrupoInteres::whereHas('estado', function($query){
            return $query->where('ESD_Valor','1');
        })->get()->pluck('GIT_Nombre', 'PK_GIT_Id');
        return view('autoevaluacion.FuentesPrimarias.DatosEncuestas.edit',compact('datos','grupos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DatosEncuestasRequest $request, $id)
    {
        $datos_encuesta = DatosEncuesta::findOrFail($id);
        $datos_encuesta->fill($request->only(['DAE_Titulo', 'DAE_Descripcion']));
        $datos_encuesta->FK_DAE_GruposInteres = $request->get('PK_GIT_Id');
        $datos_encuesta->update();
        return response(['msg' => 'Los datos han sido modificado exitosamente.',
                'title' => 'Datos Modificados!'
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
        $datos_encuesta = DatosEncuesta::findOrFail($id);
        $datos_encuesta->delete();
            return response(['msg' => 'Los datos han sido eliminados exitosamente.',
                'title' => 'Datos Eliminados!'
            ], 200) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');
    }
}
