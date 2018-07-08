<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\GruposInteresRequest;
use App\Models\Estado;
use App\Models\GrupoInteres;
use DataTables;
use Illuminate\Http\Request;

class GruposInteresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_GRUPOS_INTERES');
        $this->middleware(['permission:MODIFICAR_GRUPOS_INTERES', 'permission:VER_GRUPOS_INTERES'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_GRUPOS_INTERES', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_GRUPOS_INTERES', ['only' => ['destroy']]);
    }

    public function index()
    {
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        return view('autoevaluacion.SuperAdministrador.GruposInteres.index', compact('estados'));
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $grupos_interes = GrupoInteres::with('estado')->get();
            return Datatables::of($grupos_interes)
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(GruposInteresRequest $request)
    {
        $grupos_interes = new GrupoInteres();
        $grupos_interes->fill($request->only(['GIT_Nombre']));
        $grupos_interes->FK_GIT_Estado = $request->get('PK_ESD_Id');
        $grupos_interes->save();
        return response([
            'msg' => 'Grupo de interes registrado correctamente.',
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(GruposInteresRequest $request, $id)
    {
        $grupos_interes = GrupoInteres::findOrFail($id);
        $grupos_interes->fill($request->only(['GIT_Nombre']));
        $grupos_interes->FK_GIT_Estado = $request->get('PK_ESD_Id');
        $grupos_interes->update();
        return response([
            'msg' => 'El grupo de interes ha sido modificado exitosamente.',
            'title' => 'Grupo de Interes Modificado!'
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
        $grupos_interes = GrupoInteres::findOrFail($id);
        $grupos_interes->delete();
        return response([
            'msg' => 'El grupo de interes ha sido eliminado exitosamente.',
            'title' => '¡Grupo de Interes Eliminado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
