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
                'ACV_Nombre as nombre_archivo');
        }])
        ->get();
            return Datatables::of($docinstitucional)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->addIndexColumn()
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
       if($request->file('archivo')){
           $file= $request->file('archivo');
           $archivo = new Archivo;
           $archivo->ACV_Nombre = $file->getClientOriginalName();
           $archivo->ACV_Extension = $file->extension();
           $archivo->ruta = $file->store('DocumentosInstitucionales');
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
    public function update(Request $request, $id)
    {
        $docinstitucional = DocumentoInstitucional::findOrFail($id);
        $docinstitucional->update($request->all());
        

        return response(['msg' => 'El Lineamiento ha sido modificado exitosamente.',
                'title' => 'Lineamiento Modificado!'
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
        $docinstitucional = DocumentoInstitucional::findOrFail($id);
     /*   $id_doc= $docinstitucional->FK_DOI_Archivo;
        $archivo = Archivo::with(['documentoinstitucional'=> function($query)use($id_doc){
            return $query->where ('PK_ACV_Id',$id_doc);
        }])->get();
        Storage::delete($archivo->ruta);*/
        $docinstitucional->delete();
       
        return response(['msg' => 'El Documento ha sido eliminado exitosamente.',
                'title' => '¡Registro Eliminado!'
            ], 200) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');
    }

}

