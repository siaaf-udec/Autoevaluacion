<?php

namespace App\Http\Controllers\FuentesPrimarias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use App\Models\Encuesta;
use App\Models\Estado;
use App\Models\GrupoInteres;
use App\Models\DatosEncuesta;
use Carbon\Carbon;
use App\Http\Requests\EncuestaRequest;

class DatosEspecificosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_DATOS');
        $this->middleware(['permission:MODIFICAR_DATOS', 'permission:VER_DATOS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_DATOS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_DATOS', ['only' => ['destroy']]);
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
            $encuesta = Encuesta::with('estado','proceso','datos')->get();
            return Datatables::of($encuesta)
            ->editColumn('ECT_FechaPublicacion', function ($encuesta) {
                return $encuesta->ECT_FechaPublicacion ? with(new Carbon($encuesta->ECT_FechaPublicacion))->format('d/m/Y') : '';
            })
            ->editColumn('ECT_FechaFinalizacion', function ($encuesta) {
                return $encuesta->ECT_FechaFinalizacion ? with(new Carbon($encuesta->ECT_FechaFinalizacion))->format('d/m/Y') : '';
            })
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->make(true);
        }
        return AjaxResponse::fail(
            '¡Lo sentimos!',
            'No se pudo completar tu solicitud.'
        );

    }
    public function create()
    {
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $grupos = GrupoInteres::whereHas('estado', function($query){
            return $query->where('ESD_Valor','1');
        })->get()->pluck('GIT_Nombre', 'PK_GIT_Id');
        return view('autoevaluacion.FuentesPrimarias.DatosEspecificos.create', compact('estados','grupos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EncuestaRequest $request)
    {
        $id_proceso = session()->get('id_proceso');
        if ( empty($id_proceso ) ) {
            return response([
                'errors' => ['No ha seleccionado ningun proceso de autoevaluación'],
                'title' => '¡Error!'
            ], 422) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');     
        }
        else
        {
            $fechaInicio = Carbon::createFromFormat('d/m/Y', $request->get('ECT_FechaPublicacion'));
            $fechaFin = Carbon::createFromFormat('d/m/Y', $request->get('ECT_FechaFinalizacion'));

        if ($fechaInicio < $fechaFin) {
            $encuesta = new Encuesta();
            $encuesta->ECT_FechaPublicacion = $fechaInicio;
            $encuesta->ECT_FechaFinalizacion = $fechaFin;
            $encuesta->FK_ECT_Estado = $request->get('PK_ESD_Id');
            $encuesta->FK_ECT_Proceso = $id_proceso;
            $encuesta->FK_ECT_DatosEncuesta = $request->get('PK_DAE_Id');
            $encuesta->save();

            return response([
            'msg' => 'Datos especificos resgistrados correctamente.',
            'title' => '¡Registro exitoso!'
        ], 200) // 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
        }
        else{
            return response([
                'errors' => ['La fecha de publicacion tiene que ser menor que la fecha de finalizacion de la fase de captura de datos.'],
                'title' => '¡Error!'
            ], 422) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');
        }
    }
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
        $grupos = GrupoInteres::whereHas('estado', function($query){
            return $query->where('ESD_Valor','1');
        })->get()->pluck('GIT_Nombre', 'PK_GIT_Id');
 
        $descrip = new DatosEncuesta();
        $id_descripcion = $encuesta->datos->grupos()->pluck('PK_GIT_Id')[0];
        $descripcion = $descrip->where('FK_DAE_GruposInteres', $id_descripcion)->get()->pluck('DAE_Titulo', 'PK_DAE_Id');

         return view(
             'autoevaluacion.FuentesPrimarias.DatosEspecificos.edit',
             compact('encuesta', 'estados', 'grupos','descripcion')
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
        $encuesta = Encuesta::find($id);
        $encuesta->fill($request->only(['ECT_FechaPublicacion', 'ECT_FechaFinalizacion', 'FK_ECT_Estado','FK_ECT_Proceso','FK_ECT_DatosEncuesta']));

        $encuesta->save();


        return response(['msg' => 'El Aspecto ha sido modificado exitosamente.',
                'title' => '¡Usuario Modificado!'
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
        Encuesta::destroy($id);
        return response(['msg' => 'Los datos han sido eliminados exitosamente.',
                'title' => 'Datos Eliminados!'
            ], 200) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');
    }
}
