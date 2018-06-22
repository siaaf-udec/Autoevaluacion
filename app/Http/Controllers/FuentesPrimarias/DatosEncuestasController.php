<?php

namespace App\Http\Controllers\FuentesPrimarias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

use App\Models\DatosEncuesta;
use App\Models\GrupoInteres;

class DatosEncuestasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware([
            'permission:CREAR_ENCUESTAS',
            'permission:VER_ENCUESTAS',
            'permission:MODIFICAR_ENCUESTAS',
            'permission:ELIMINAR_ENCUESTAS'
            ]);

    }
    public function index()
    {
        return view('autoevaluacion.FuentesPrimarias.DatosEncuestas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $datosEncuesta = DatosEncuesta::select('PK_DAE_Id','DAE_Titulo','DAE_Descripcion',
            'FK_DAE_GruposInteres')->with(['grupos' => function($query){
                return $query->select('PK_GIT_Id','GIT_Nombre as nombre');
            }
        ])->get();
            return Datatables::of($datosEncuesta)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->addIndexColumn()
                ->make(true);
        }
        dd($datosEncuesta);
        return AjaxResponse::fail(
            '¡Lo sentimos mmmm!',
            'No se pudo completar tu solicitud.'
        );

    }
    public function create()
    {
        $items = GrupoInteres::pluck('GIT_Nombre', 'PK_GIT_Id');
        return view('autoevaluacion.FuentesPrimarias.DatosEncuestas.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DatosEncuesta::create($request->all());
        return response(['msg' => 'Datos registrados correctamente.',
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
        $items = GrupoInteres::pluck('GIT_Nombre', 'PK_GIT_Id');
        return view('autoevaluacion.FuentesPrimarias.DatosEncuestas.edit', [
            'user' => DatosEncuesta::findOrFail($id),
            'edit' => true,
        ], compact('items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = DatosEncuesta::find($id);
        $user->fill($request->all());
        $user->save();
        return response(['msg' => 'Los datos han sido modificado exitosamente.',
                'title' => 'Datos Modificadoa!'
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
        DatosEncuesta::destroy($id);

            return response(['msg' => 'Los datos han sido eliminados exitosamente.',
                'title' => 'Datos Eliminados!'
            ], 200) // 200 Status Code: Standard response for successful HTTP request
                ->header('Content-Type', 'application/json');
    }
}
