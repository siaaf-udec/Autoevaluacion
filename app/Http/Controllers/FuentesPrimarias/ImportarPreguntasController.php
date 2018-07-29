<?php

namespace App\Http\Controllers\FuentesPrimarias;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportarPreguntasRequest;
use App\Models\Caracteristica;
use App\Models\Factor;
use App\Models\PonderacionRespuesta;
use App\Models\Pregunta;
use App\Models\Proceso;
use App\Models\RespuestaPregunta;
use App\Models\TipoRespuesta;
use Excel;
use Illuminate\Http\Request;
use App\Jobs\ImportarPreguntas;
use Illuminate\Support\Facades\Storage;


class ImportarPreguntasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('permission:IMPORTAR_PREGUNTAS', ['only' => ['create', 'store']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('autoevaluacion.FuentesPrimarias.Preguntas.importar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImportarPreguntasRequest $request)
    {
        $archivo = $request->file('archivo');
        $results = "";
        if ($archivo) {
            $url_temporal = Storage::url($archivo->store('public'));
            ImportarPreguntas::dispatch($url_temporal, session()->get('id_proceso'));
        }


        return response(['msg' => 'Preguntas registradas correctamente.',
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
