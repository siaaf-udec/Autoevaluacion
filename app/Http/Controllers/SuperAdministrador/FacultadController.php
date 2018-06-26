<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FacultadesRequest;
use App\Models\Estado;
use App\Models\Facultad;
use DataTables;


class FacultadController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_FACULTADES');
        $this->middleware(['permission:MODIFICAR_FACULTADES', 'permission:VER_FACULTADES'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_FACULTADES', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_FACULTADES', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estados = Estado::pluck('ESD_Nombre', 'PK_ESD_Id');
        return view('autoevaluacion.SuperAdministrador.Facultades.index', compact('estados'));
    }
    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $facultades = Facultad::with('estado')->get();
            return Datatables::of($facultades)
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
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FacultadesRequest $request)
    {
        $facultad = new Facultad();
        $facultad->fill($request->only(['FCD_Nombre', 'FCD_Descripcion']));
        $facultad->FK_FCD_Estado = $request->get('PK_ESD_Id');
        $facultad->save();

        return response([
            'msg' => 'Facultad registrada correctamente.',
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FacultadesRequest $request, $id)
    {
        $facultad = Facultad::findOrFail($id);
        $facultad->fill($request->only(['FCD_Nombre', 'FCD_Descripcion']));
        $facultad->FK_FCD_Estado = $request->get('PK_ESD_Id');
        $facultad->update();


        return response([
            'msg' => 'La facultad ha sido modificado exitosamente.',
            'title' => 'Facultad Modificada!'
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
        $facultad = Facultad::findOrFail($id);
        $facultad->delete();


        return response([
            'msg' => 'La Facultad ha sido eliminada exitosamente.',
            'title' => '¡Facultad Eliminada!'
        ], 200) // 200 Status Code: Standard response for successful HTTP request
            ->header('Content-Type', 'application/json');
    }
}
