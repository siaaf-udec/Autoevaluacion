<?php

namespace App\Http\Controllers\FuentesSecundarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndicadoresDocumentalesRequest;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\Estado;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\IndicadorDocumental;
use App\Models\Autoevaluacion\Lineamiento;
use DataTables;
use Illuminate\Http\Request;


class IndicadorDocumentalController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_INDICADORES_DOCUMENTALES');
        $this->middleware(['permission:MODIFICAR_INDICADORES_DOCUMENTALES', 'permission:VER_INDICADORES_DOCUMENTALES'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_INDICADORES_DOCUMENTALES', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_INDICADORES_DOCUMENTALES', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.FuentesSecundarias.IndicadoresDocumentales.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $indicadores_documentales = IndicadorDocumental::with('caracteristica.factor.lineamiento')
                ->with(['estado' => function ($query) {
                    return $query->select('PK_ESD_Id', 'ESD_Nombre');
                }])
                ->get();
            return DataTables::of($indicadores_documentales)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->addColumn('nombre_factor', function ($indicadores_documentales) {
                    return $indicadores_documentales->caracteristica->factor->nombre_factor;
                })
                ->addColumn('nombre_caracteristica', function ($indicadores_documentales) {
                    return $indicadores_documentales->caracteristica->nombre_caracteristica;
                })
                ->addColumn('nombre_indicador', function ($indicadores_documentales) {
                    return $indicadores_documentales->nombre_indicador;
                })
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
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');

        return view('autoevaluacion.FuentesSecundarias.IndicadoresDocumentales.create',
            compact('lineamientos', 'estados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(IndicadoresDocumentalesRequest $request)
    {
        $indicador_documental = new IndicadorDocumental();
        $indicador_documental->fill($request->only(['IDO_Nombre', 'IDO_Descripcion', 'IDO_Identificador']));
        $indicador_documental->FK_IDO_Caracteristica = $request->get('PK_CRT_Id');
        $indicador_documental->FK_IDO_Estado = $request->get('PK_ESD_Id');
        $indicador_documental->save();

        return response(['msg' => 'Indicador documental registrado correctamente.',
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
        $indicadores_documentales = IndicadorDocumental::where('FK_IDO_Caracteristica', $id)
            ->get()    
            ->pluck('nombre_indicador', 'PK_IDO_Id');
        return json_encode($indicadores_documentales);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $indicador = IndicadorDocumental::findOrFail($id);
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');

        $factor = new Factor();
        $id_factor = $indicador->caracteristica->factor->lineamiento()->pluck('PK_LNM_Id')[0];
        $factores = $factor->where('FK_FCT_Lineamiento', $id_factor)->get()->pluck('nombre_factor', 'PK_FCT_Id');

        $caracteristica = new Caracteristica();
        $id_caracteristica = $indicador->caracteristica->factor()->pluck('PK_FCT_Id')[0];
        $caracteristicas = $caracteristica->where('FK_CRT_Factor', $id_caracteristica)->get()->pluck('nombre_caracteristica', 'PK_CRT_Id');
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');

        return view(
            'autoevaluacion.FuentesSecundarias.IndicadoresDocumentales.edit',
            compact('indicador', 'lineamientos', 'factores', 'caracteristicas', 'estados')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(IndicadoresDocumentalesRequest $request, $id)
    {
        $indicador = IndicadorDocumental::find($id);
        $indicador->fill($request->only(['IDO_Nombre', 'IDO_Descripcion', 'IDO_Identificador']));
        $indicador->FK_IDO_Caracteristica = $request->get('PK_CRT_Id');
        $indicador->FK_IDO_Estado = $request->get('PK_ESD_Id');


        $indicador->update();


        return response(['msg' => 'El Indicador documental ha sido modificado exitosamente.',
            'title' => 'Indicador Modificado!'
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
        IndicadorDocumental::destroy($id);

        return response(['msg' => 'El Indicador documental ha sido eliminado exitosamente.',
            'title' => 'Indicador documental Eliminado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
