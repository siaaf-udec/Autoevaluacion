<?php

namespace App\Http\Controllers\FuentesPrimarias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PonderacionRespuesta;
use DataTables;
use Session;

class PonderacionRespuestasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return voif\Illuminate\Http\Response
     */
    protected $id;

    public function __construct()
    {
        $this->middleware('permission:ACCEDER_PONDERACION_RESPUESTAS');
        $this->middleware(['permission:MODIFICAR_PONDERACION_RESPUESTAS', 'permission:VER_PONDERACION_RESPUESTAS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_PONDERACION_RESPUESTAS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_PONDERACION_RESPUESTAS', ['only' => ['destroy']]);
    }
      /**
     * Show the form for editing the specified resource.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        session()->put('id', $id);
        return view('autoevaluacion.FuentesPrimarias.PonderacionRespuestas.index');
    }
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $ponderacionRespuestas = PonderacionRespuesta::whereHas('tipo', function($query){
                return $query->where('FK_PRT_TipoRespuestas',session()->get('id'));
            })->get();
            return Datatables::of($ponderacionRespuestas)
                ->make(true);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ponderacionRespuestas = new PonderacionRespuesta();
        $ponderacionRespuestas->fill($request->only(['PRT_Titulo', 'PRT_Ponderacion']));
        $ponderacionRespuestas->FK_PRT_TipoRespuestas = session()->get('id');
        $ponderacionRespuestas->save();

        return response([
            'msg' => 'Ponderacion registrada correctamente.',
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
        $ponderacionRespuestas = PonderacionRespuesta::findOrFail($id);
        $ponderacionRespuestas->fill($request->only(['PRT_Titulo', 'PRT_Ponderacion']));
        $ponderacionRespuestas->FK_PRT_TipoRespuestas = session()->get('id');
        $ponderacionRespuestas->update();

        return response([
            'msg' => 'La ponderacion ha sido modificada exitosamente.',
            'title' => 'Ponderacion Modificada!'
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
        $ponderacionRespuestas = PonderacionRespuesta::findOrFail($id);
        $ponderacionRespuestas->delete();

        return response([
            'msg' => 'La ponderacion ha sido eliminado exitosamente.',
            'title' => '¡Ponderacion Eliminada!'
        ], 200) // 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');

    }
    
}
