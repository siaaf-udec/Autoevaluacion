<?php

namespace App\Http\Controllers\FuentesPrimarias;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use App\Models\Encuesta;
use App\Models\Estado;
use App\Models\GrupoInteres;
use App\Models\Proceso;
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
        $this->middleware('permission:ACCEDER_ENCUESTAS');
        $this->middleware(['permission:MODIFICAR_ENCUESTAS', 'permission:VER_ENCUESTAS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_ENCUESTAS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_ENCUESTAS', ['only' => ['destroy']]);
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
            $encuesta = Auth::user()->procesos()->with('programa.sede','encuestas.estado')->get();
            return Datatables::of($encuesta)
            ->editColumn('encuestas.ECT_FechaPublicacion', function ($encuestas) {
                return $encuestas->encuestas->ECT_FechaPublicacion ? with(new Carbon($encuestas->encuestas->ECT_FechaPublicacion))->format('d/m/Y') : '';
            })
            ->editColumn('encuestas.ECT_FechaFinalizacion', function ($encuestas) {
                return $encuestas->encuestas->ECT_FechaFinalizacion ? with(new Carbon($encuestas->encuestas->ECT_FechaFinalizacion))->format('d/m/Y') : '';
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
        return view('autoevaluacion.FuentesPrimarias.DatosEspecificos.create', compact('estados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EncuestaRequest $request)
    {
        $id_proceso = $request->PK_PCS_Id;
        if ( !empty($id_proceso ) ) {
            $proceso = Proceso::with('fase')->
            where('PK_PCS_Id','=',$id_proceso)->first();
            if($proceso->fase->FSS_Nombre != "construccion")
            {
            return response([
                'errors' => ['El proceso seleccionado no se encuentra en fase de construccion'],
                'title' => '¡Error!'
            ], 422) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');
            }     
        } 
        $fechaInicio = Carbon::createFromFormat('d/m/Y', $request->get('ECT_FechaPublicacion'));
        $fechaFin = Carbon::createFromFormat('d/m/Y', $request->get('ECT_FechaFinalizacion'));

        if ($fechaInicio < $fechaFin) {
            $encuesta = new Encuesta();
            $encuesta->ECT_FechaPublicacion = $fechaInicio;
            $encuesta->ECT_FechaFinalizacion = $fechaFin;
            $encuesta->FK_ECT_Estado = $request->get('PK_ESD_Id');
            $encuesta->FK_ECT_Proceso = $request->get('PK_PCS_Id');
            $encuesta->save();

            return response([
            'msg' => 'Datos especificos resgistrados correctamente.',
            'title' => '¡Registro exitoso!'
        ], 200) // 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
        }
        else{
            return response([
                'errors' => ['La fecha de publicacion tiene que ser menor que la fecha de finalizacion.'],
                'title' => '¡Error!'
            ], 422) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');
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
         return view(
             'autoevaluacion.FuentesPrimarias.DatosEspecificos.edit',
             compact('encuesta', 'estados')
             );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EncuestaRequest $request, $id)
    {
        $id_proceso = $request->PK_PCS_Id;
        if ( !empty($id_proceso ) ) {
            $proceso = Proceso::with('fase')->
            where('PK_PCS_Id','=',$id_proceso)->first();
            if($proceso->fase->FSS_Nombre != "construccion")
            {
            return response([
                'errors' => ['El proceso seleccionado no se encuentra en fase de construccion'],
                'title' => '¡Error!'
            ], 422) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');
            }     
        }
        $fechaInicio = Carbon::createFromFormat('d/m/Y', $request->get('ECT_FechaPublicacion'));
        $fechaFin = Carbon::createFromFormat('d/m/Y', $request->get('ECT_FechaFinalizacion'));
        
        if ($fechaInicio < $fechaFin) {
            $encuesta = Encuesta::find($id);
            $encuesta->ECT_FechaPublicacion = $fechaInicio;
            $encuesta->ECT_FechaFinalizacion = $fechaFin;
            $encuesta->FK_ECT_Estado = $request->get('PK_ESD_Id');
            $encuesta->FK_ECT_Proceso = $request->get('PK_PCS_Id');
            $encuesta->update();
        
            return response([
                'msg' => 'Datos especificos resgistrados correctamente.',
                'title' => '¡Registro exitoso!'
                ], 200) // 200 Status Code: Standard response for successful HTTP request
                    ->header('Content-Type', 'application/json');
        }
        else{
            return response([
                'errors' => ['La fecha de publicacion tiene que ser menor que la fecha de finalizacion'],
                'title' => '¡Error!'
            ], 422) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');
        }
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
