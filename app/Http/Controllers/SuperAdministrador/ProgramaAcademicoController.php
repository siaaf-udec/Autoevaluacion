<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use App\Models\ProgramaAcademico;
use App\Models\Sede;
use App\Models\Facultad;
use App\Models\Estado;
use App\Http\Requests\ProgramasAcademicosRequest;


class ProgramaAcademicoController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_PROGRAMAS_ACADEMICOS');
        $this->middleware(['permission:MODIFICAR_PROGRAMAS_ACADEMICOS', 'permission:VER_PROGRAMAS_ACADEMICOS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_PROGRAMAS_ACADEMICOS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_PROGRAMAS_ACADEMICOS', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.ProgramasAcademicos.index');
    }
    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $programas_academicos = ProgramaAcademico::with(['facultad' => function($query){
                return $query->select('PK_FCD_Id', 'FCD_Nombre');

            }])
            ->with(['sede' => function($query){
                return $query->select('PK_SDS_Id', 'SDS_Nombre');
            }])
            ->with(['estado' => function ($query) {
                return $query->select('PK_ESD_Id', 'ESD_Nombre');
            }])
            ->get();
            return DataTables::of($programas_academicos)
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
        $sedes = Sede::pluck('SDS_Nombre', 'PK_SDS_Id');
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $facultades = Facultad::pluck('FCD_Nombre', 'PK_FCD_Id');

        return view(
            'autoevaluacion.SuperAdministrador.ProgramasAcademicos.create',
            compact('sedes', 'facultades', 'estados')
        );
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgramasAcademicosRequest $request)
    {
        $programa_academico = new ProgramaAcademico();
        $programa_academico->fill($request->only(['PAC_Nombre', 'PAC_Descripcion']));
        $programa_academico->FK_PAC_Sede = $request->get('PK_SDS_Id');
        $programa_academico->FK_PAC_Estado = $request->get('PK_ESD_Id');
        $programa_academico->FK_PAC_Facultad = $request->get('PK_FCD_Id');
        $programa_academico->save();

        return response([
            'msg' => 'Programa academico registrado correctamente.',
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
        $programa_academico = ProgramaAcademico::findOrFail($id);
        $sedes = Sede::pluck('SDS_Nombre', 'PK_SDS_Id');
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        $facultades = Facultad::pluck('FCD_Nombre', 'PK_FCD_Id');


        return view(
            'autoevaluacion.SuperAdministrador.ProgramasAcademicos.edit',
            compact('programa_academico', 'sedes', 'estados', 'facultades')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProgramasAcademicosRequest $request, $id)
    {
        $programa_academico = ProgramaAcademico::find($id);
        $programa_academico->fill($request->only(['PAC_Nombre', 'PAC_Descripcion']));
        $programa_academico->FK_PAC_Sede = $request->get('PK_SDS_Id');
        $programa_academico->FK_PAC_Estado = $request->get('PK_ESD_Id');
        $programa_academico->FK_PAC_Facultad = $request->get('PK_FCD_Id');

        $programa_academico->update();


        return response([
            'msg' => 'El Programa academico ha sido modificado exitosamente.',
            'title' => 'Programa academico Modificado!'
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
        ProgramaAcademico::destroy($id);

        return response([
            'msg' => 'El programa academico ha sido eliminado exitosamente.',
            'title' => 'Programa academico Eliminado!'
        ], 200) // 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
    }
}