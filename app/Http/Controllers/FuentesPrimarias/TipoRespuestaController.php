<?php

namespace App\Http\Controllers\FuentesPrimarias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Estado;
use App\Models\TipoRespuesta;
use App\Models\PonderacionRespuesta;
use DataTables;
use App\Http\Requests\TipoRespuestaRequest;

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
        return view('autoevaluacion.FuentesPrimarias.TipoRespuestas.index');
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
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');

        return view('autoevaluacion.FuentesPrimarias.TipoRespuestas.create', compact('estados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoRespuestaRequest $request)
    {
        $sumatoria = 0;
        $cantidadRespuestas = $request->TRP_CantidadRespuestas;
        for($i=1;$i<=$cantidadRespuestas;$i++)
        {
            $valorPonderacion = $request->get('Ponderacion_'.$i);
            $sumatoria = $sumatoria + $valorPonderacion;
        }
        $totalPonderacion = $request->TRP_TotalPonderacion;
        if($sumatoria != $totalPonderacion )
        {
            return response([
                'errors' => ['La suma de ponderaciones no corresponde con el total de ponderacion digitado'],
                'title' => '¡Error!'
            ], 422) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');  
        }

        $tipoRespuestas = new TipoRespuesta();
        $tipoRespuestas->fill($request->only(['TRP_TotalPonderacion', 'TRP_CantidadRespuestas','TRP_Descripcion']));
        $tipoRespuestas->FK_TRP_Estado = $request->get('PK_ESD_Id');
        $tipoRespuestas->save();
        $insertedId = $tipoRespuestas->PK_TRP_Id;
        $cantidad = $request->TRP_CantidadRespuestas;
        for($i=1;$i<=$cantidad;$i++)
        {
            $ponderacion = new PonderacionRespuesta();
            $ponderacion->PRT_Ponderacion = $request->get('Ponderacion_'.$i);
            $ponderacion->FK_PRT_TipoRespuestas = $insertedId;
            $ponderacion->save();

        }
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
        $respuesta = TipoRespuesta::findOrFail($id);

        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');

        $ponderaciones = PonderacionRespuesta::where('FK_PRT_TipoRespuestas', $id)->get();
    
        return view('autoevaluacion.FuentesPrimarias.TipoRespuestas.edit',
            compact('respuesta','estados', 'ponderaciones')
            );
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
        $tipoRespuestas->fill($request->only(['TRP_TotalPonderacion','TRP_Descripcion']));
        $tipoRespuestas->FK_TRP_Estado = $request->get('PK_ESD_Id');
        $tipoRespuestas->update();

        $ponderaciones = PonderacionRespuesta::where('FK_PRT_TipoRespuestas',$id)->get();
        foreach($ponderaciones as $ponderacion){
            $prt = PonderacionRespuesta::find($ponderacion->PK_PRT_Id);
            $prt->PRT_Ponderacion = $request->get($ponderacion->PK_PRT_Id);
            $prt->FK_PRT_TipoRespuestas = $id;
            $prt->save(); 
        }
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
