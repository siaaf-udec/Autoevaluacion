<?php

namespace App\Http\Controllers\FuentesPrimarias;

use App\Http\Controllers\Controller;
use App\Models\Estado;
use App\Models\PonderacionRespuesta;
use App\Models\TipoRespuesta;
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
            ->addColumn('estado', function ($tipoRespuestas) {
                if (!$tipoRespuestas->estado) {
                    return '';
                } elseif (!strcmp($tipoRespuestas->estado->ESD_Nombre, 'HABILITADO')) {
                    return "<span class='label label-sm label-success'>".$tipoRespuestas->estado->ESD_Nombre. "</span>";
                } else {
                    return "<span class='label label-sm label-danger'>".$tipoRespuestas->estado->ESD_Nombre . "</span>";
                }
                return "<span class='label label-sm label-primary'>".$tipoRespuestas->estado->ESD_Nombre . "</span>";
            })
            ->rawColumns(['estado'])
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoRespuestaRequest $request)
    {
        $sumatoria = 0;
        for($i=1;$i<=$request->TRP_CantidadRespuestas;$i++)
        {
            $sumatoria = $sumatoria + $request->get('Ponderacion_'.$i);
        }
        if($sumatoria != $request->TRP_TotalPonderacion)
        {
            return response([
                'errors' => ['La suma de ponderaciones no corresponde con el total de ponderacion digitado'],
                'title' => '¡Error!'
            ], 422) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');  
        }
        else{
            $tipoRespuestas = new TipoRespuesta();
            $tipoRespuestas->fill($request->only(['TRP_TotalPonderacion', 'TRP_CantidadRespuestas','TRP_Descripcion']));
            $tipoRespuestas->FK_TRP_Estado = $request->get('PK_ESD_Id');
            $tipoRespuestas->save();
            for($i=1;$i<=$request->TRP_CantidadRespuestas;$i++)
            {
                $ponderacion = new PonderacionRespuesta();
                $ponderacion->PRT_Ponderacion = $request->get('Ponderacion_'.$i);
                $ponderacion->FK_PRT_TipoRespuestas = $tipoRespuestas->PK_TRP_Id;
                $ponderacion->save();
            }
            return response([
                'msg' => 'Tipo de respuesta registrada correctamente.',
                'title' => '¡Registro exitoso!'
            ], 200) // 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
        }
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
        $respuesta = TipoRespuesta::findOrFail($id);
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $ponderaciones = PonderacionRespuesta::where('FK_PRT_TipoRespuestas', $id)->get();
        return view('autoevaluacion.FuentesPrimarias.TipoRespuestas.edit',
            compact('respuesta', 'estados', 'ponderaciones')
        );
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoRespuestaRequest $request, $id)
    {
        $sumatoria = 0;
        foreach(PonderacionRespuesta::where('FK_PRT_TipoRespuestas',$id)->get() as $ponderacion)
        {
            $sumatoria = $sumatoria + $request->get($ponderacion->PK_PRT_Id);
        }
        if($sumatoria != $request->TRP_TotalPonderacion )
        {
            return response([
                'errors' => ['La suma de ponderaciones no corresponde con el total de ponderacion digitado'],
                'title' => '¡Error!'
            ], 422) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');  
        }
        else
        {
            $tipoRespuestas = TipoRespuesta::findOrFail($id);
            $tipoRespuestas->fill($request->only(['TRP_TotalPonderacion','TRP_Descripcion']));
            $tipoRespuestas->FK_TRP_Estado = $request->get('PK_ESD_Id');
            $tipoRespuestas->update();
            foreach(PonderacionRespuesta::where('FK_PRT_TipoRespuestas',$id)->get() as $ponderacion){
                $ponderacionRpt = PonderacionRespuesta::find($ponderacion->PK_PRT_Id);
                $ponderacionRpt->PRT_Ponderacion = $request->get($ponderacion->PK_PRT_Id);
                $ponderacionRpt->FK_PRT_TipoRespuestas = $id;
                $ponderacionRpt->save(); 
            }
            return response([
                'msg' => 'El tipo de respuesta ha sido modificado exitosamente.',
                'title' => 'Tipo de respuesta Modificado!'
            ], 200) // 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipoRespuestas = TipoRespuesta::findOrFail($id);
        $tipoRespuestas->delete();
        return response([
            'msg' => 'El tipo de respuesta ha sido eliminado exitosamente.',
            'title' => '¡Tipo de respuesta Eliminado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
