<?php

namespace App\Http\Controllers\FuentesPrimarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\DatosEncuestasRequest;
use App\Models\Autoevaluacion\DatosEncuesta;
use App\Models\Autoevaluacion\GrupoInteres;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class DatosEncuestasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_DATOS');
        $this->middleware(['permission:MODIFICAR_DATOS', 'permission:VER_DATOS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_DATOS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_DATOS', ['only' => ['destroy']]);
    }

    public function index()
    {
        $grupos = GrupoInteres::whereHas('estado', function ($query) {
            return $query->where('ESD_Valor', '=', '1');
        })->get()->pluck('GIT_Nombre', 'PK_GIT_Id');
        return view('autoevaluacion.FuentesPrimarias.DatosEncuestas.index', compact('grupos'));
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
        return AjaxResponse::fail(
            '¡Lo sentimos!',
            'No se pudo completar tu solicitud.'
        );
    }
    public function create()
    {
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
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
    public function update(DatosEncuestasRequest $request, $id)
    {
        $datos_encuesta = DatosEncuesta::findOrFail($id);
        $datos_encuesta->fill($request->only(['DAE_Titulo', 'DAE_Descripcion']));
        $datos_encuesta->FK_DAE_GruposInteres = $request->get('PK_GIT_Id');
        $datos_encuesta->update();
        return response(['msg' => 'Los datos han sido modificado exitosamente.',
            'title' => 'Datos Modificados!'
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
        $datos_encuesta = DatosEncuesta::findOrFail($id);
        $datos_encuesta->delete();
        return response(['msg' => 'Los datos han sido eliminados exitosamente.',
            'title' => 'Datos Eliminados!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
