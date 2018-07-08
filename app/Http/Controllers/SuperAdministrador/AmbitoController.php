<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Http\Requests\AmbitoRequest;
use App\Models\AmbitoResponsabilidad;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class AmbitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware([
            'permission:CREAR_AMBITOS',
            'permission:VER_AMBITOS'
        ]);

    }

    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.Ambito.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $tipos = AmbitoResponsabilidad::all();
            return Datatables::of($tipos)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->addIndexColumn()
                ->make(true);
        }
        return AjaxResponse::fail(
            '¡Lo sentimos mmmm!',
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AmbitoRequest $request)
    {
        AmbitoResponsabilidad::create($request->except('_token'));
        return response([
            'msg' => 'Ambito registrado correctamente.',
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
    public function update(AmbitoRequest $request, $id)
    {
        $user = AmbitoResponsabilidad::find($id);
        $user->fill($request->all());
        $user->save();
        return response([
            'msg' => 'El Ambito ha sido modificado exitosamente.',
            'title' => '¡Ambito Modificado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        AmbitoResponsabilidad::destroy($id);

        return response([
            'msg' => 'El Ambito ha sido eliminado exitosamente.',
            'title' => '¡Ambito Eliminado!'
        ], 200)// 200 Status Code: Standard response for successful HTTP request
        ->header('Content-Type', 'application/json');


    }
}
