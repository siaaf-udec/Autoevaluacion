<?php

namespace App\Http\Controllers\FuentesPrimarias;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Sede;

class EstablecerPreguntasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sedes = Sede::where('FK_SDS_Estado','=','1')->pluck('SDS_Nombre', 'PK_SDS_Id');
        return view('autoevaluacion.FuentesPrimarias.EstablecerPreguntas.index',compact('sedes'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->get('PK_PCS_Id');
        $encuesta = Encuesta::with(['estado' => function($query){
            return $query->select('PK_ESD_Id','ESD_Nombre as estado');
        }
        ])->with(['proceso' => function($query){
        return $query->select('PK_PCS_Id','PCS_Nombre as proceso');
        }
        ])->with(['datos' => function($query){
            return $query->select('PK_DAE_Id','DAE_Descripcion as datos');
            }
        ])->get();
        return Datatables::of($encuesta)
            ->removeColumn('created_at')
            ->removeColumn('updated_at')
            ->addIndexColumn()
            ->make(true);
    return AjaxResponse::fail(
        '¡Lo sentimos mmmm!',
        'No se pudo completar tu solicitud.'
    );
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function encuestas($id)
    {

    }
}
