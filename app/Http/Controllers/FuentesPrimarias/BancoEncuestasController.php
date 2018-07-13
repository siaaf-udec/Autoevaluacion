<?php

namespace App\Http\Controllers\FuentesPrimarias;

use Illuminate\Http\Request;
use App\Http\Requests\BancoEncuestasRequest;
use App\Http\Controllers\Controller;
use App\Models\BancoEncuestas;
use DataTables;


class BancoEncuestasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:ACCEDER_BANCO_ENCUESTAS');
        $this->middleware(['permission:MODIFICAR_BANCO_ENCUESTAS', 'permission:VER_BANCO_ENCUESTAS'], ['only' => ['edit', 'update']]);
        $this->middleware('permission:CREAR_BANCO_ENCUESTAS', ['only' => ['create', 'store']]);
        $this->middleware('permission:ELIMINAR_BANCO_ENCUESTAS', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('autoevaluacion.FuentesPrimarias.BancoEncuestas.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {if ($request->ajax() && $request->isMethod('GET')) {
        $banco_encuestas = BancoEncuestas::all();
        return Datatables::of($banco_encuestas)
            ->removeColumn('created_at')
            ->removeColumn('updated_at')
            ->make(true);
    }
    return AjaxResponse::fail(
        '¡Lo sentimos!',
        'No se pudo completar tu solicitud.'
    );
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('autoevaluacion.FuentesPrimarias.BancoEncuestas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BancoEncuestasRequest $request)
    {
        $banco_encuestas = new BancoEncuestas();
        $banco_encuestas->fill($request->only(['BEC_Nombre', 'BEC_Descripcion']));
        $banco_encuestas->save();
        return response(['msg' => 'Datos de encuesta registrados correctamente.',
            'title' => '¡Registro exitoso!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
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
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $datos = BancoEncuestas::findOrFail($id);
        return view('autoevaluacion.FuentesPrimarias.BancoEncuestas.edit',compact('datos'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BancoEncuestasRequest $request, $id)
    {
        $banco_encuestas = BancoEncuestas::findOrFail($id);
        $banco_encuestas->fill($request->only(['BEC_Nombre', 'BEC_Descripcion']));
        $banco_encuestas->update();
        return response(['msg' => 'Los datos han sido modificados exitosamente.',
            'title' => 'Datos Modificados!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
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
        $banco_encuestas = BancoEncuestas::findOrFail($id);
        $banco_encuestas->delete();
        return response(['msg' => 'La encuesta ha sido eliminada exitosamente.',
            'title' => 'Encuesta Eliminada!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }
}