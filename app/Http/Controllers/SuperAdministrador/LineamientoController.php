<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use App\Models\Lineamiento;
use App\Http\Requests\LineamientosRequest;
use Excel;
use App\Models\Factor;
use App\Models\Caracteristica;
use App\Models\Aspecto;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LineamientosRequest $request)
    {
        $archivo = $request->file('archivo');
        $results = "";
        $id = Lineamiento::create($request->except('archivo'))->PK_LNM_Id;
        if ($archivo) {
            try{
                Excel::selectSheets('FACTORES', 'CARACTERISTICAS', 'ASPECTOS')->load($archivo->getRealPath(), function ($reader) use ($id) {
                    // get all rows from the sheet
                    $sheets = $reader->all()->toArray();
                    $factores = [];

                    $count = count($sheets);
                    if ($count <= 3 and $count > 0) {
                        //Factores
                        foreach ($sheets[0] as $row) {
                            $factor = new Factor();
                            $factor->FCT_Nombre = $row['nombre'];
                            $factor->FCT_Descripcion = $row['descripcion'];
                            $factor->FCT_Identificador = $row['numero_factor'];
                            $factor->FCT_Ponderacion_Factor = $row['ponderacion'];

                            $factor->FK_FCT_Lineamiento = $id;
                            $factor->FK_FCT_Estado = 1;
                            $factor->save();
                            $factores[$row['numero_factor']] = $factor->PK_FCT_Id;
                        }
                    }
                    if ($count <= 3 and $count > 1) {
                        //Caracteristicas
                        $caracacteristicas = [];
                        foreach ($sheets[1] as $row) {
                            $caracacteristica = new Caracteristica();
                            $caracacteristica->CRT_Nombre = $row['nombre'];
                            $caracacteristica->CRT_Descripcion = $row['descripcion'];
                            $caracacteristica->CRT_Identificador = $row['numero_caracteristica'];
                            $caracacteristica->FK_CRT_Estado = 1;
                            $caracacteristica->FK_CRT_Factor = $factores[$row['factor']];
                            $caracacteristica->save();
                            $caracacteristicas[$row['numero_caracteristica']] = $caracacteristica->PK_CRT_Id;
                        }
                    }
                    if ($count == 3) {
                        foreach ($sheets[2] as $row) {
                            $aspecto = new Aspecto();
                            $aspecto->ASP_Nombre = $row['nombre'];
                            $aspecto->ASP_Descripcion = $row['descripcion'];
                            $aspecto->ASP_Identificador = $row['identificador'];
                            $aspecto->FK_ASP_Caracteristica = $caracacteristicas[$row['caracteristica']];
                            $aspecto->save();
                        }
                    }
                });
            }catch (\Exception $e) {
                return response(['errors' => ['Error por favor verifique el documento e intentelo de nuevo.'],
                    'title' => '¡Error!'
                ], 422) // 200 Status Code: Standard response for successful HTTP request
                    ->header('Content-Type', 'application/json');
            }
        }
        

        return response(['msg' => 'Lineamiento registrado correctamente.',
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
        $lineamiento = Lineamiento::findOrFail($id);

        return view(
            'autoevaluacion.SuperAdministrador.Lineamientos.edit',
        compact('lineamiento')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LineamientosRequest $request, $id)
    {
        $lineamiento = Lineamiento::findOrFail($id);
        $lineamiento->update($request->all());
        

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
        $lineamiento = Lineamiento::findOrFail($id);
        $lineamiento->delete();

        return response(['msg' => 'El Lineamiento ha sido eliminado exitosamente.',
                'title' => '¡Rol Eliminado!'
            ], 200) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');
    }
}
