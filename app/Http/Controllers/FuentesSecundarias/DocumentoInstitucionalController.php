<?php

namespace App\Http\Controllers\FuentesSecundarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentoInstitucionalRequest;
use App\Models\Autoevaluacion\Archivo;
use App\Models\Autoevaluacion\DocumentoInstitucional;
use App\Models\Autoevaluacion\GrupoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;


class DocumentoInstitucionalController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:ACCEDER_DOCUMENTOS_INSTITUCIONALES');
        $this->middleware(['permission:MODIFICAR_DOCUMENTOS_INSTITUCIONALES', 'permission:VER_DOCUMENTOS_INSTITUCIONALES'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_DOCUMENTOS_INSTITUCIONALES', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_DOCUMENTOS_INSTITUCIONALES', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('autoevaluacion.FuentesSecundarias.DocumentoInstitucional.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $docinstitucional = DocumentoInstitucional::with('archivo', 'grupodocumento')
                ->get();
            return Datatables::of($docinstitucional)
                ->addColumn('archivo', function ($docinstitucional) {
                    if (!$docinstitucional->archivo) {
                        return '<a class="btn btn-success btn-xs" href="' . $docinstitucional->link .
                            '"target="_blank" role="button">Enlace al documento</a>';
                    } else {
                        $ruta = url($docinstitucional->archivo->ruta);
                        return '<a class="btn btn-success btn-xs" href="' . $ruta .
                            '" target="_blank" role="button">' . $docinstitucional->archivo->ACV_Nombre . '</a>';


                    }
                })
                ->rawColumns(['archivo'])
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
        $grupodocumentos = GrupoDocumento::pluck('GRD_Nombre', 'PK_GRD_Id');
        return view('autoevaluacion.FuentesSecundarias.DocumentoInstitucional.create', compact('grupodocumentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentoInstitucionalRequest $request)
    {
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $archivo = new Archivo;
            $archivo->ACV_Nombre = $file->getClientOriginalName();
            $archivo->ACV_Extension = $file->extension();
            $carpeta = GrupoDocumento::find($request->FK_DOI_GrupoDocumento);
            $nombrecarpeta = $carpeta->GRD_Nombre;
            $archivo->ruta = Storage::url($file->store('public/DocumentosInstitucionales/' . $nombrecarpeta));
            $archivo->save();

            $docinstitucional = new DocumentoInstitucional;
            $docinstitucional->DOI_Nombre = $request->DOI_Nombre;
            $docinstitucional->DOI_Descripcion = $request->DOI_Descripcion;
            $docinstitucional->link = $request->link;
            $docinstitucional->FK_DOI_Archivo = $archivo->PK_ACV_Id;
            $docinstitucional->FK_DOI_GrupoDocumento = $request->FK_DOI_GrupoDocumento;
            $docinstitucional->save();
        } else {
            DocumentoInstitucional::create($request->except('archivo'));
        }

        return response(['msg' => 'El documento ha sido almacenado exitosamente.',
            'title' => '¡Registro realizado exitosamente!'
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
        $grupodocumentos = GrupoDocumento::pluck('GRD_Nombre', 'PK_GRD_Id');
        $documento = DocumentoInstitucional::findOrFail($id);
        $size = $documento->archivo ? filesize(public_path($documento->archivo->ruta)) : null;
        return view('autoevaluacion.FuentesSecundarias.DocumentoInstitucional.edit', [
            'user' => $documento,
            'edit' => true,
        ], compact('grupodocumentos', 'size'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentoInstitucionalRequest $request, $id)
    {
        $borraArchivo = false;

        $documento = DocumentoInstitucional::findOrFail($id);

        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombre = $archivo->getClientOriginalName();
            $extension = $archivo->getClientOriginalExtension();
            $carpeta = GrupoDocumento::find($request->FK_DOI_GrupoDocumento);
            $nombrecarpeta = $carpeta->GRD_Nombre;
            $url = Storage::url($archivo->store('public/DocumentosInstitucionales/' . $nombrecarpeta));
            if ($documento->archivo) {
                $ruta = str_replace('storage', 'public', $documento->archivo->ruta);
                Storage::delete($ruta);
                $archivos = Archivo::findOrfail($documento->FK_DOI_Archivo);
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
        if ($request->get('link') != null && $documento->archivo) {
            $documento->FK_DOI_Archivo = null;
            $borraArchivo = true;
            $ruta = $documento->archivo->ruta;
            $id = $documento->FK_DOI_Archivo;
        }

        $documento->fill($request->only([
            'DOI_Nombre',
            'DOI_Descripcion',
            'link',
        ]));

        if (isset($id_archivo)) {
            $documento->FK_DOI_Archivo = $id_archivo;
        }

        $documento->FK_DOI_GrupoDocumento = $request->FK_DOI_GrupoDocumento;
        $documento->update();

        if ($borraArchivo) {
            Archivo::destroy($id);
        }

        return response(['msg' => 'El Documento ha sido modificado exitosamente.',
            'title' => 'Documento Institucional Modificado!'
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
        $documento = DocumentoInstitucional::findOrfail($id);
        if ($documento->archivo) {
            $ruta = str_replace('storage', 'public', $documento->archivo->ruta);
            Storage::delete($ruta);
            $documento->archivo()->delete();
        } else {
            $documento->delete();
        }
        return response(['msg' => 'El Documento ha sido eliminado exitosamente.',
            'title' => '¡Registro Eliminado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

}