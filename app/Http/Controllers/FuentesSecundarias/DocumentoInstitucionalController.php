<?php

namespace App\Http\Controllers\FuentesSecundarias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GrupoDocumento;
use App\Models\DocumentoInstitucional;
use App\Models\Archivo;
use Yajra\Datatables\Datatables;
use App\Http\Requests\DocumentoInstitucionalRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class DocumentoInstitucionalController extends Controller
{

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
            $docinstitucional = DocumentoInstitucional::with(['grupodocumento' => function ($query) {
            return $query->select('PK_GRD_Id','GRD_Nombre as nombre');
        }])
        ->with(['archivo' => function ($query) {
            return $query->select('PK_ACV_Id',
                'ACV_Nombre','ruta');
        }])
        ->get();
            return Datatables::of($docinstitucional)
            ->addColumn('archivo', function ($docinstitucional) {
                if (!$docinstitucional->archivo) {          
                    return  $docinstitucional->link;    
                }
                else{
                    
                    return $docinstitucional->archivo->ruta;

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
        return view('autoevaluacion.FuentesSecundarias.DocumentoInstitucional.create',compact('grupodocumentos'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentoInstitucionalRequest $request)
    {
       if($request->hasFile('archivo')){
           $file= $request->file('archivo');
           $archivo = new Archivo;
           $archivo->ACV_Nombre = $file->getClientOriginalName();
           $archivo->ACV_Extension = $file->extension();
           $archivo->ruta = Storage::url($file->store('public/DocumentosInstitucionales'));
           $archivo->save();

           $docinstitucional= new DocumentoInstitucional;
           $docinstitucional->DOI_Nombre = $request->DOI_Nombre;
           $docinstitucional->DOI_Descripcion = $request->DOI_Descripcion;
           $docinstitucional->link = $request->link;
           $docinstitucional->FK_DOI_Archivo = $archivo->PK_ACV_Id;
           $docinstitucional->FK_DOI_GrupoDocumento = $request->FK_DOI_GrupoDocumento;
           $docinstitucional->save();
       }
       else{
        DocumentoInstitucional::create($request->except('archivo'));
       }
       
       return response(['msg' => 'El documento ha sido almacenado exitosamente.',
                'title' => '¡Registro realizado exitosamente!'
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grupodocumentos = GrupoDocumento::pluck('GRD_Nombre', 'PK_GRD_Id');
        return view('autoevaluacion.FuentesSecundarias.DocumentoInstitucional.edit', [
            'user' => DocumentoInstitucional::findOrFail($id),
            'edit' => true,
        ], compact('grupodocumentos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentoInstitucionalRequest $request, $id)
    {
        $documento = DocumentoInstitucional::findOrFail($id);
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombre = pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $archivo->getClientOriginalExtension();
            $url = Storage::url($archivo->store('public/DocumentosInstitucionales'));

            if ($documento->archivo) {
                $ruta = str_replace('storage', 'public', $documento->archivo->ruta);
                Storage::delete($ruta);
                $archivos = Archivo::findOrfail($documento->FK_DOI_Archivo);
                $archivos->ACV_Nombre = $nombre;
                $archivos->ACV_Extension = $extension;
                $archivos->ruta = $url;
                $archivos->update();
                $id_archivo = $archivos->PK_ACV_Id;


            }
            else{
                $archivos = new Archivo();
                $archivos->ACV_Nombre = $nombre;
                $archivos->ACV_Extension = $extension;
                $archivos->ruta = $url;
                $archivos->save();

                $id_archivo = $archivos->PK_ACV_Id; 
                
            }
            
        }
        $documento->fill($request->only([
            'DOI_Nombre',
            'DOI_Descripcion',
            'link',
        ]));

        $documento->FK_DOI_Archivo = isset($id_archivo) ? $id_archivo : null;
        $documento->FK_DOI_GrupoDocumento= $request->FK_DOI_GrupoDocumento;
        $documento->update();



        return response(['msg' => 'El Documento ha sido modificado exitosamente.',
                'title' => 'Documento Modificado!'
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
        $documento = DocumentoInstitucional::findOrfail($id);
        $ruta = str_replace('storage', 'public', $documento->archivo->ruta);
        Storage::delete($ruta);
        $documento->archivo()->delete();
       
        return response(['msg' => 'El Documento ha sido eliminado exitosamente.',
                'title' => '¡Registro Eliminado!'
            ], 200) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');
    }

}

