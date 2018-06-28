<?php

namespace App\Http\Controllers\FuentesPrimarias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Estado;
use App\Models\TipoRespuesta;
use DataTables;

class TipoRespuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_TIPO_RESPUESTAS');
        $this->middleware(['permission:MODIFICAR_TIPO_RESPUESTAS', 'permission:VER_TIPO_RESPUESTAS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_TIPO_RESPUESTAS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_TIPO_RESPUESTAS', ['only' => ['destroy']]);
    }
    public function index()
    {
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        return view('autoevaluacion.FuentesPrimarias.TipoRespuestas.index', compact('estados'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $tipoRespuestas = TipoRespuesta::with('estado')->get();
            return Datatables::of($tipoRespuestas)
                ->make(true);
        }
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tipoRespuestas = new TipoRespuesta();
        $tipoRespuestas->fill($request->only(['TRP_TotalPonderacion', 'TRP_CantidadRespuestas','TRP_Descripcion']));
        $tipoRespuestas->FK_TRP_Estado = $request->get('PK_ESD_Id');
        $tipoRespuestas->save();

        return response([
            'msg' => 'Tipo de respuesta registrada correctamente.',
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
        //
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
        $tipoRespuestas = TipoRespuesta::findOrFail($id);
        $tipoRespuestas->fill($request->only(['TRP_TotalPonderacion', 'TRP_CantidadRespuestas','TRP_Descripcion']));
        $tipoRespuestas->FK_TRP_Estado = $request->get('PK_ESD_Id');
        $tipoRespuestas->update();

        return response([
            'msg' => 'El tipo de respuesta ha sido modificado exitosamente.',
            'title' => 'Tipo de respuesta Modificado!'
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
        $tipoRespuestas = TipoRespuesta::findOrFail($id);
        $tipoRespuestas->delete();

        return response([
            'msg' => 'El tipo de respuesta ha sido eliminado exitosamente.',
            'title' => '¡Tipo de respuesta Eliminado!'
        ], 200) // 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
    }
}
