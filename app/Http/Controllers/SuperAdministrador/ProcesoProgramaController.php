<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProcesosProgramasRequest;
use App\Models\Autoevaluacion\Facultad;
use App\Models\Autoevaluacion\Fase;
use App\Models\Autoevaluacion\Lineamiento;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\ProgramaAcademico;
use App\Models\Autoevaluacion\Sede;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProcesoProgramaController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_PROCESOS_PROGRAMAS');
        $this->middleware(['permission:MODIFICAR_PROCESOS_PROGRAMAS', 'permission:VER_PROCESOS_PROGRAMAS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_PROCESOS_PROGRAMAS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_PROCESOS_PROGRAMAS', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.ProcesosProgramas.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            if (Gate::allows('SUPERADMINISTRADOR')) {
                $procesos_programas = Proceso::with(['fase' => function ($query) {
                    return $query->select('PK_FSS_Id', 'FSS_Nombre');
                }])
                    ->with('programa.sede')
                    ->with('programa.facultad')
                    ->where('PCS_Institucional', '=', '0')
                    ->get();

                return DataTables::of($procesos_programas)
                    ->editColumn('PCS_FechaInicio', function ($proceso_programa) {
                        return $proceso_programa->PCS_FechaInicio ? with(new Carbon($proceso_programa->PCS_FechaInicio))->format('d/m/Y') : '';
                    })
                    ->editColumn('PCS_FechaFin', function ($proceso_programa) {
                        return $proceso_programa->PCS_FechaFin ? with(new Carbon($proceso_programa->PCS_FechaFin))->format('d/m/Y') : '';
                        ;
                    })
                    ->removeColumn('created_at')
                    ->removeColumn('updated_at')
                    ->make(true);
            } else {
                $procesos_programas = Proceso::with(['fase' => function ($query) {
                    return $query->select('PK_FSS_Id', 'FSS_Nombre');
                }])
                    ->with('programa.sede')
                    ->with('programa.facultad')
                    ->where('PCS_Institucional', '=', '0')
                    ->where('FK_PCS_Programa', '=', Auth::user()->id_programa)
                    ->get();

                return DataTables::of($procesos_programas)
                    ->editColumn('PCS_FechaInicio', function ($proceso_programa) {
                        return $proceso_programa->PCS_FechaInicio ? with(new Carbon($proceso_programa->PCS_FechaInicio))->format('d/m/Y') : '';
                    })
                    ->editColumn('PCS_FechaFin', function ($proceso_programa) {
                        return $proceso_programa->PCS_FechaFin ? with(new Carbon($proceso_programa->PCS_FechaFin))->format('d/m/Y') : '';
                        ;
                    })
                    ->removeColumn('created_at')
                    ->removeColumn('updated_at')
                    ->make(true);
            }
        }
    }
        
    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::allows('SUPERADMINISTRADOR')){
            $sedes = Sede::pluck('SDS_Nombre', 'PK_SDS_Id');
            $facultades = Facultad::pluck('FCD_Nombre', 'PK_FCD_Id');
            $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
            $fases = Fase::pluck('FSS_Nombre', 'PK_FSS_Id');
        }
        else{
            $sedes = Sede::where('PK_SDS_Id', '=', Auth::user()->programa->FK_PAC_Sede)
                           ->pluck('SDS_Nombre', 'PK_SDS_Id');
            $facultades = Facultad::where('PK_FCD_Id', '=',  Auth::user()->programa->FK_PAC_Facultad)
            ->pluck('FCD_Nombre', 'PK_FCD_Id');
            $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
            $fases = Fase::pluck('FSS_Nombre', 'PK_FSS_Id');
        }
        return view(
            'autoevaluacion.SuperAdministrador.ProcesosProgramas.create',
            compact('sedes', 'facultades', 'lineamientos', 'fases')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProcesosProgramasRequest $request)
    {
        $fechaInicio = Carbon::createFromFormat('d/m/Y', $request->get('PCS_FechaInicio'));
        $fechaFin = Carbon::createFromFormat('d/m/Y', $request->get('PCS_FechaFin'));

        $proceso = new Proceso();
        $proceso->fill($request->only(['PCS_Nombre']));
        $proceso->PCS_FechaInicio = $fechaInicio;
        $proceso->PCS_FechaFin = $fechaFin;
        $nombres = explode(' ', ProgramaAcademico::where('PK_PAC_Id',$request->get('PK_PAC_Id'))->first()->PAC_Nombre);
        $slug="";foreach($nombres as $nombre) $slug=$slug.'_'.$nombre;
        $proceso->PCS_Slug_Procesos = "Proceso-.".$slug;

        $proceso->FK_PCS_Fase = 3;
        $proceso->FK_PCS_Programa = $request->get('PK_PAC_Id');
        $proceso->FK_PCS_Lineamiento = $request->get('PK_LNM_Id');
        $proceso->save();

        return response([
                'msg' => 'Proceso registrado correctamente.',
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proceso = Proceso::findOrFail($id);
        $sedes = Sede::pluck('SDS_Nombre', 'PK_SDS_Id');
        $facultades = Facultad::pluck('FCD_Nombre', 'PK_FCD_Id');
        $lineamientos = Lineamiento::pluck('LNM_Nombre', 'PK_LNM_Id');
        $fases = Fase::pluck('FSS_Nombre', 'PK_FSS_Id');

        $programas = new ProgramaAcademico();
        $programas = $programas::where('FK_PAC_Sede', '=', $proceso->programa->sede->PK_SDS_Id)
            ->where('FK_PAC_Facultad', '=', $proceso->programa->facultad->PK_FCD_Id)
            ->pluck('PAC_Nombre', 'PK_PAC_Id');


        return view(
            'autoevaluacion.SuperAdministrador.ProcesosProgramas.edit',
            compact('proceso', 'sedes', 'facultades', 'programas', 'lineamientos', 'fases')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProcesosProgramasRequest $request, $id)
    {
        $proceso = Proceso::find($id);
        $proceso->fill($request->only(['PCS_Nombre']));
        $proceso->PCS_FechaInicio = Carbon::createFromFormat('d/m/Y', $request->get('PCS_FechaInicio'));
        $proceso->PCS_FechaFin = Carbon::createFromFormat('d/m/Y', $request->get('PCS_FechaFin'));

        $proceso->FK_PCS_Fase = $request->get('PK_FSS_Id');
        $proceso->FK_PCS_Programa = $request->get('PK_PAC_Id');
        $proceso->FK_PCS_Lineamiento = $request->get('PK_LNM_Id');
        $nombres = explode(' ', ProgramaAcademico::where('PK_PAC_Id',$request->get('PK_PAC_Id'))->first()->PAC_Nombre);
        $slug="";foreach($nombres as $nombre) $slug=$slug.'_'.$nombre;
        $proceso->PCS_Slug_Procesos = $slug;
        $proceso->update();


        return response([
            'msg' => 'El proceso ha sido modificado exitosamente.',
            'title' => 'Proceso Modificado!'
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
        Proceso::destroy($id);

        return response([
            'msg' => 'El Proceso ha sido eliminado exitosamente.',
            'title' => 'Proceso Eliminado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }


    public function ObtenerProgramas($id_sede, $id_facultad)
    {
        $programas = ProgramaAcademico::where('FK_PAC_Sede', '=', $id_sede)
            ->where('FK_PAC_Facultad', '=', $id_facultad)
            ->where('FK_PAC_Estado', '=', '1')
            ->pluck('PAC_Nombre', 'PK_PAC_Id');
        return json_encode($programas);
    }
}
