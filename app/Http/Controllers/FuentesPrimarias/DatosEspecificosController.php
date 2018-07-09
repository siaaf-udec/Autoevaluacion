<?php

namespace App\Http\Controllers\FuentesPrimarias;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EncuestaRequest;
use App\Models\DatosEncuesta;
use App\Models\Encuesta;
use App\Models\Estado;
use App\Models\GrupoInteres;
use App\Models\Proceso;
use Carbon\Carbon;
use DataTables;

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
            $encuesta = Auth::user()->procesos()
            ->with('programa.sede','encuestas.estado')
            ->whereHas('encuestas.estado')
            ->get();
            return Datatables::of($encuesta)
            ->editColumn('encuestas.ECT_FechaPublicacion', function ($encuestas) {
                return $encuestas->encuestas->ECT_FechaPublicacion ? with(new Carbon($encuestas->encuestas->ECT_FechaPublicacion))->format('d/m/Y') : '';
            })
            ->editColumn('encuestas.ECT_FechaFinalizacion', function ($encuestas) {
                return $encuestas->encuestas->ECT_FechaFinalizacion ? with(new Carbon($encuestas->encuestas->ECT_FechaFinalizacion))->format('d/m/Y') : '';
            })
            ->addColumn('estado', function ($encuesta) {
                if (!$encuesta->encuestas->estado) {
                    return '';
                } elseif (!strcmp($encuesta->encuestas->estado->ESD_Nombre, 'HABILITADO')) {
                    return "<span class='label label-sm label-success'>".$encuesta->encuestas->estado->ESD_Nombre. "</span>";
                } else {
                    return "<span class='label label-sm label-danger'>".$encuesta->encuestas->estado->ESD_Nombre . "</span>";
                }
                return "<span class='label label-sm label-primary'>".$encuesta->encuestas->estado->ESD_Nombre . "</span>";
            })
            ->rawColumns(['estado'])
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(EncuestaRequest $request)
    {
        $encuesta = new Encuesta();
        $encuesta->ECT_FechaPublicacion = Carbon::createFromFormat('d/m/Y', $request->get('ECT_FechaPublicacion'));;
        $encuesta->ECT_FechaFinalizacion = Carbon::createFromFormat('d/m/Y', $request->get('ECT_FechaFinalizacion'));
        $encuesta->FK_ECT_Estado = $request->get('PK_ESD_Id');
        $encuesta->FK_ECT_Proceso = $request->get('PK_PCS_Id');
        $encuesta->save();
        return response([
            'msg' => 'Datos especificos resgistrados correctamente.',
            'title' => '¡Registro exitoso!'
            ], 200) // 200 Status Code: Standard response for successful HTTP request
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
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EncuestaRequest $request, $id)
    {
        $encuesta = Encuesta::find($id);
        $encuesta->ECT_FechaPublicacion = Carbon::createFromFormat('d/m/Y', $request->get('ECT_FechaPublicacion'));;
        $encuesta->ECT_FechaFinalizacion = Carbon::createFromFormat('d/m/Y', $request->get('ECT_FechaFinalizacion'));
        $encuesta->FK_ECT_Estado = $request->get('PK_ESD_Id');
        $encuesta->FK_ECT_Proceso = $request->get('PK_PCS_Id');
        $encuesta->update();
            return response([
                'msg' => 'Datos especificos resgistrados correctamente.',
                'title' => '¡Registro exitoso!'
                ], 200) // 200 Status Code: Standard response for successful HTTP request
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
        Encuesta::destroy($id);
        return response(['msg' => 'Los datos han sido eliminados exitosamente.',
            'title' => 'Datos Eliminados!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
