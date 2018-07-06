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
     * @return void \Illuminate\Http\Response
     */

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
                ->addIndexColumn()
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
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }
    public function mostrarPonderaciones($id)
    {
        $ponderaciones = PonderacionRespuesta::where('FK_PRT_TipoRespuestas',$id)
        ->get()
        ->pluck('PRT_Ponderacion','PK_PRT_Id')
        ->toArray();
        return json_encode($ponderaciones);
    }
    
}
