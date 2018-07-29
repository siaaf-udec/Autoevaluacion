<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\LineamientosRequest;
use App\Models\Aspecto;
use App\Models\Caracteristica;
use App\Models\Factor;
use App\Models\Lineamiento;
use DataTables;
use Excel;
use Illuminate\Http\Request;
use App\Jobs\ImportarLineamiento;
use Illuminate\Support\Facades\Storage;

class LineamientoController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:ACCEDER_LINEAMIENTOS');
        $this->middleware(['permission:MODIFICAR_LINEAMIENTOS', 'permission:VER_LINEAMIENTOS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_LINEAMIENTOS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_LINEAMIENTOS', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.Lineamientos.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $lineamiento = Lineamiento::all();
            return Datatables::of($lineamiento)
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
        return view('autoevaluacion.SuperAdministrador.Lineamientos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(LineamientosRequest $request)
    {
        $archivo = $request->file('archivo');
        $results = "";
        $id = Lineamiento::create($request->except('archivo'))->PK_LNM_Id;
        if ($archivo) {
            $url_temporal = Storage::url($archivo->store('public'));
            ImportarLineamiento::dispatch($url_temporal, $id);       
        }
        return response(['msg' => 'Lineamiento registrado correctamente.',
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
        $lineamiento = Lineamiento::findOrFail($id);

        return view(
            'autoevaluacion.SuperAdministrador.Lineamientos.edit',
            compact('lineamiento')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(LineamientosRequest $request, $id)
    {
        $lineamiento = Lineamiento::findOrFail($id);
        $lineamiento->update($request->all());


        return response(['msg' => 'El Lineamiento ha sido modificado exitosamente.',
            'title' => 'Lineamiento Modificado!'
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
        $lineamiento = Lineamiento::findOrFail($id);
        $lineamiento->delete();

        return response(['msg' => 'El Lineamiento ha sido eliminado exitosamente.',
            'title' => '¡Rol Eliminado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}
