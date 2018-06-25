<?php

namespace App\Http\Controllers\FuentesPrimarias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\Encuesta;
use App\Models\Estado;
use App\Models\Sede;
use App\Models\GrupoInteres;
use App\Models\Proceso;
use App\Models\DatosEncuesta;

class DatosEspecificosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware([
            'permission:CONSTRUIR_ENCUESTAS',
            ]);

    }
    public function index()
    {
        return view('autoevaluacion.FuentesPrimarias.DatosEspecificos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $encuesta = Encuesta::with(['estado' => function($query){
                return $query->select('PK_ESD_Id','ESD_Nombre as estado');
            }
            ])->with(['proceso' => function($query){
            return $query->select('PK_PCS_Id','PCS_Nombre as proceso');
            }
            ])->with(['datos' => function($query){
                return $query->select('PK_DAE_Id','DAE_Descripcion as datos');
                }
            ])->get();
            return Datatables::of($encuesta)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->addIndexColumn()
                ->make(true);
        }
        return AjaxResponse::fail(
            '¡Lo sentimos mmmm!',
            'No se pudo completar tu solicitud.'
        );

    }
    public function create()
    {
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $grupos =  GrupoInteres::where('FK_GIT_Estado','=','1')->pluck('GIT_Nombre', 'PK_GIT_Id');
        $sedes = Sede::where('FK_SDS_Estado','=','1')->pluck('SDS_Nombre', 'PK_SDS_Id');
        return view('autoevaluacion.FuentesPrimarias.DatosEspecificos.create', compact('estados','sedes','grupos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $encuesta = new Encuesta();
        $encuesta->fill($request->only(['ECT_FechaPublicacion', 'ECT_FechaFinalizacion', 'FK_ECT_Estado','FK_ECT_Proceso','FK_ECT_DatosEncuesta']));
        //$encuesta->FK_ECT_Proceso = $request->get('PK_PCS_Id');
        //$encuesta->FK_ECT_DatosEncuesta = $request->get('PK_DAE_Id');
        $encuesta->save();
        return response(['msg' => 'Datos Especificos registrados correctamente.',
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $encuesta = Encuesta::findOrFail($id);

        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $grupos =  GrupoInteres::where('FK_GIT_Estado','=','1')->pluck('GIT_Nombre', 'PK_GIT_Id');
        $sedes = Sede::where('FK_SDS_Estado','=','1')->pluck('SDS_Nombre', 'PK_SDS_Id');

        $proceso = new Proceso();
        $id_proceso = $encuesta->sede->proceso()->pluck('PK_SDS_Id')[0];
        $procesos = $proceso->where('FK_PCS_Sede', $id_proceso)->get()->pluck('PCS_Nombre', 'PK_PCS_Id');
 
        $descrip = new DatosEncuesta();
        $id_descripcion = $encuesta->datos()->pluck('PK_GIT_Id')[0];
        $descripcion = $descrip->where('FK_DAE_GruposInteres', $id_descripcion)->get()->pluck('DAE_Titulo', 'PK_DAE_Id');

         return view(
             'autoevaluacion.FuentesPrimarias.DatosEspecificos.edit',
             compact('encuesta', 'estados', 'grupos', 'sedes', 'procesos','descripcion')
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
