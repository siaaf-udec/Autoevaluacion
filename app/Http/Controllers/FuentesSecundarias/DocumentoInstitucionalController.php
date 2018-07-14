<?php

namespace App\Http\Controllers\FuentesSecundarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentoInstitucionalRequest;
use App\Models\Archivo;
use App\Models\DocumentoInstitucional;
use App\Models\GrupoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables;


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
            $docinstitucional = DocumentoInstitucional::with('archivo', 'grupodocumento')      
        ->get();
            return Datatables::of($docinstitucional)
            ->addColumn('archivo', function ($docinstitucional) {
                if (!$docinstitucional->archivo) {          
                    return '<a class="btn btn-success btn-xs" href="' . $docinstitucional->link .
                            '"target="_blank" role="button">Enlace al documento</a>';   
                }
                else{
                    $ruta = url($docinstitucional->archivo->ruta);
                    return '<a class="btn btn-success btn-xs" href="'.$ruta.
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
            $archivo->ruta = Storage::url($file->store('public/DocumentosInstitucionales'));
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
        $documento= DocumentoInstitucional::findOrFail($id);
           return view('autoevaluacion.FuentesSecundarias.DocumentoInstitucional.edit', [
            'user' => $documento,
            'edit' => true,
        ], compact('grupodocumentos'));
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
        $documento = DocumentoInstitucional::findOrFail($id);
        if($request->hasFile('archivo')){
            $file = $request->file('archivo');
            $nombre = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $url = Storage::url($file->store('public/DocumentosInstitucionales'));
            if($documento->archivo){
                $ruta = str_replace('storage', 'public', $documento->archivo->ruta);
                Storage::delete($ruta);   
                $archivo = Archivo::findOrfail($documento->FK_DOI_Archivo);
                $archivo->ACV_Nombre = $nombre;
                $archivo->ACV_Extension = $extension;
                $archivo->ruta = $url;
                $archivo->save();
                $id_archivo = $archivo->PK_ACV_Id; 
 
            }
            else{
                $archivo = new Archivo;
                $archivo->ACV_Nombre = $nombre;
                $archivo->ACV_Extension = $extension;
                $archivo->ruta = $url;
                $archivo->save();
                $id_archivo = $archivo->PK_ACV_Id;

                          
            } 
                $documento->link = null;
                $documento->FK_DOI_Archivo = $id_archivo;  
        }
        else{
            if($request->link){
                $ruta = str_replace('storage', 'public', $documento->archivo->ruta);
                Storage::delete($ruta);
                $documento->FK_DOI_Archivo = null;
                
            }
        }
        $documento -> fill($request->except('archivo'));
        $documento->save();
        
        
        
        
        return response(['msg' => 'El Documento ha sido modificado exitosamente.',
            'title' => 'Documento Modificado!'
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
        if($documento->archivo){
        $ruta = str_replace('storage', 'public', $documento->archivo->ruta);
        Storage::delete($ruta);
        $documento->archivo()->delete(); 
        }else{
            $documento->delete();
        }
        return response(['msg' => 'El Documento ha sido eliminado exitosamente.',
            'title' => '¡Registro Eliminado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
    
}

