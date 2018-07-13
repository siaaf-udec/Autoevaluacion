<?php

namespace App\Http\Controllers\FuentesSecundarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentosAutoevaluacionRequest;
use App\Models\Archivo;
use App\Models\Caracteristica;
use App\Models\Dependencia;
use App\Models\DocumentoAutoevaluacion;
use App\Models\Factor;
use App\Models\IndicadorDocumental;
use App\Models\Proceso;
use App\Models\TipoDocumento;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DocumentoAutoevaluacionController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_DOCUMENTOS_AUTOEVALUACION');
        $this->middleware(['permission:MODIFICAR_DOCUMENTOS_AUTOEVALUACION', 'permission:VER_DOCUMENTOS_AUTOEVALUACION'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_DOCUMENTOS_AUTOEVALUACION', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_DOCUMENTOS_AUTOEVALUACION', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.FuentesSecundarias.DocumentosAutoevaluacion.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {

            $documentos_autoevaluacion = DocumentoAutoevaluacion::with('indicadorDocumental.caracteristica.factor')
                ->with('archivo')
                ->with(['tipoDocumento' => function($query){
                    return $query->select('PK_TDO_Id', 'TDO_Nombre');
                }])
                ->with(['dependencia' => function($query){
                    return $query->select('PK_DPC_Id', 'DPC_Nombre');
                }])
                ->where('FK_DOA_Proceso', '=', session()->get('id_proceso'))
                ->get();

            return DataTables::of($documentos_autoevaluacion)
                ->addColumn('file', function ($documento_autoevaluacion) {


                    if (!$documento_autoevaluacion->archivo) {


                        return '<a class="btn btn-success btn-xs" href="' . $documento_autoevaluacion->DOA_Link .
                            '"target="_blank" role="button">Descargar</a>';
                    } else {

                        return '<a class="btn btn-success btn-xs" href="' .
                            $documento_autoevaluacion->archivo->ruta .

                            '" target="_blank" role="button">Descargar</a>';

                    }
                })
                ->addColumn('nombre', function ($documento_autoevaluacion) {
                    if ($documento_autoevaluacion->archivo) {
                        return $documento_autoevaluacion->archivo->ACV_Nombre;
                    } 
                    else {
                        return 'Link';
                    }
                })
                ->rawColumns(['file'])
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
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
        $id_lineamiento = Proceso::findOrFail(session()->get('id_proceso'))->FK_PCS_Lineamiento;

        $factores = Factor::has('caracteristica.indicadores_documentales')
            ->where('FK_FCT_Lineamiento', '=', $id_lineamiento)
            ->where('FK_FCT_estado', '=', '1')
            ->get()
            ->pluck('FCT_Nombre', 'PK_FCT_Id');
        $dependencias = Dependencia::pluck('DPC_Nombre', 'PK_DPC_Id');
        $tipo_documentos = TipoDocumento::pluck('TDO_Nombre', 'PK_TDO_Id');

        return view('autoevaluacion.FuentesSecundarias.DocumentosAutoevaluacion.create',
            compact('factores', 'dependencias', 'tipo_documentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentosAutoevaluacionRequest $request)
    {
        $proceso = Proceso::findOrFail(session()->get('id_proceso'));

        if ($proceso->FK_PCS_Fase == 4) {
            if ($request->hasFile('archivo')) {
                $archivo = $request->file('archivo');
                $nombre = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $archivo->getClientOriginalExtension();
                $url = Storage::url($archivo->store('public/documentos_autoevaluacion'));

                $archivos = new Archivo();
                $archivos->ACV_Nombre = $nombre;
                $archivos->ACV_Extension = $extension;
                $archivos->ruta = $url;
                $archivos->save();

                $id_archivo = $archivos->PK_ACV_Id;
            }

            $documento_auto = new DocumentoAutoevaluacion();
            $documento_auto->fill($request->only(['IDO_Nombre',
            'DOA_Numero',
            'DOA_Anio',
            'DOA_Link',
            'DOA_DescripcionGeneral',
            'DOA_ContenidoEspecifico',
            'DOA_ContenidoAdicional',
            'DOA_Observaciones']));

            $documento_auto->FK_DOA_Archivo = isset($id_archivo) ? $id_archivo : null;
            $documento_auto->FK_DOA_IndicadorDocumental = $request->get('PK_IDO_Id');
            $documento_auto->FK_DOA_TipoDocumento = $request->get('PK_TDO_Id');
            $documento_auto->FK_DOA_Dependencia = $request->get('PK_DPC_Id');
            $documento_auto->FK_DOA_Proceso = session()->get('id_proceso');
            $documento_auto->save();

            return response(['msg' => 'El documento se ha registrado correctamente.',
            'title' => '¡Registro exitoso!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
        }
         return response([
                'errors' => ['El proceso se debe encontrar en fase de captura de datos para poder subir documentos.'],
                'title' => '¡Error!'
            ], 422)// 200 Status Code: Standard response for successful HTTP request
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
        $documento = DocumentoAutoevaluacion::findOrFail($id);
        $this->authorize('autorizar', $documento->FK_DOA_Proceso);
        $factores = Factor::has('caracteristica.indicadores_documentales')
            ->where('FK_FCT_Lineamiento', '=', $documento->proceso->FK_PCS_Lineamiento)
            ->where('FK_FCT_estado', '=', '1')
            ->get()
            ->pluck('FCT_Nombre', 'PK_FCT_Id');

        $caracteristicas = Caracteristica::has('indicadores_documentales')
            ->where('FK_CRT_Factor', '=', $documento->indicadorDocumental->caracteristica->FK_CRT_Factor)
            ->where('FK_CRT_estado', '=', '1')
            ->get()
            ->pluck('CRT_Nombre', 'PK_CRT_Id');

        $indicadores = IndicadorDocumental::where('FK_IDO_Caracteristica', '=', $documento->indicadorDocumental->FK_IDO_Caracteristica)
            ->pluck('IDO_Nombre', 'PK_IDO_Id');
        $dependencias = Dependencia::pluck('DPC_Nombre', 'PK_DPC_Id');
        $tipo_documentos = TipoDocumento::pluck('TDO_Nombre', 'PK_TDO_Id');
        $size = $documento->archivo?filesize(public_path($documento->archivo->ruta)):null;

        return view(
            'autoevaluacion.FuentesSecundarias.DocumentosAutoevaluacion.edit',
            compact('documento', 'factores', 'caracteristicas', 'indicadores', 'dependencias', 'tipo_documentos', 'size')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentosAutoevaluacionRequest $request, $id)
    {
        $borraArchivo = false;

        $documento = DocumentoAutoevaluacion::findOrFail($id);
        $this->authorize('autorizar', $documento->FK_DOA_Proceso);
        $proceso = Proceso::find($documento->FK_DOA_Proceso);

         if ($proceso->FK_PCS_Fase == 4 || $proceso->FK_PCS_Fase == 5) {
             if ($request->hasFile('archivo')) {
                 $archivo = $request->file('archivo');
                 $nombre = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
                 $extension = $archivo->getClientOriginalExtension();
                 $url = Storage::url($archivo->store('public/documentos_autoevaluacion'));

                 if ($documento->archivo) {
                     $ruta = str_replace('storage', 'public', $documento->archivo->ruta);
                     Storage::delete($ruta);
                     $archivos = Archivo::findOrfail($documento->FK_DOA_Archivo);
                     $archivos->ACV_Nombre = $nombre;
                     $archivos->ACV_Extension = $extension;
                     $archivos->ruta = $url;
                     $archivos->update();
                     $id_archivo = $archivos->PK_ACV_Id;
                 } else {
                     $archivos = new Archivo();
                     $archivos->ACV_Nombre = $nombre;
                     $archivos->ACV_Extension = $extension;
                     $archivos->ruta = $url;
                     $archivos->save();

                     $id_archivo = $archivos->PK_ACV_Id;
                 }
             }
             if ($request->get('DOA_Link') != null && $documento->archivo) {
                 $documento->FK_DOA_Archivo = null;
                 $borraArchivo = true;
                 $ruta = $documento->archivo->ruta;
                 $id = $documento->FK_DOA_Archivo;
             }

             $documento->fill($request->only([
            'IDO_Nombre',
            'DOA_Numero',
            'DOA_Anio',
            'DOA_Link',
            'DOA_DescripcionGeneral',
            'DOA_ContenidoEspecifico',
            'DOA_ContenidoAdicional',
            'DOA_Observaciones'
        ]));
             if (isset($id_archivo)) {
                 $documento->FK_DOA_Archivo = $id_archivo;
             }

        
             $documento->FK_DOA_IndicadorDocumental = $request->get('PK_IDO_Id');
             $documento->FK_DOA_TipoDocumento = $request->get('PK_TDO_Id');
             $documento->FK_DOA_Dependencia = $request->get('PK_DPC_Id');
             $documento->update();

             if ($borraArchivo) {
                 $ruta = str_replace('storage', 'public', $ruta);
                 Storage::delete($ruta);
                 Archivo::destroy($id);
             }


             return response(['msg' => 'El Indicador documental ha sido modificado exitosamente.',
            'title' => 'Indicador Modificado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
        }
        return response([
                'errors' => ['El proceso se debe encontrar en fase de captura de datos o de consolidación para poder modificar la información de los documentos.'],
                'title' => '¡Error!'
            ], 422)// 200 Status Code: Standard response for successful HTTP request
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
        $documento = DocumentoAutoevaluacion::findOrfail($id);
        $this->authorize('autorizar', $documento->FK_DOA_Proceso);
        if ($documento->archivo) {
            $ruta = str_replace('storage', 'public', $documento->archivo->ruta);
            Storage::delete($ruta);
            $documento->archivo()->delete();
        }
        $documento->delete();


        return response(['msg' => 'El documento ha sido eliminado exitosamente.',
            'title' => 'Documento Eliminado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

    public function obtenerCaracteristicas($id)
    {
        $caracteristicas = Caracteristica::has('indicadores_documentales')
            ->where('FK_CRT_Factor', '=', $id)
            ->where('FK_CRT_estado', '=', '1')
            ->get()
            ->pluck('CRT_Nombre', 'PK_CRT_Id');
        return json_encode($caracteristicas);
    }
}
