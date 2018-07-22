<?php

namespace App\Http\Controllers\Publico;

use Illuminate\Http\Request;
use App\Http\Requests\SolucionEncuestaRequest;
use App\Http\Controllers\Controller;
use App\Models\Sede;
use App\Models\Encuesta;
use App\Models\Encuestado;
use App\Models\SolucionEncuesta;
use App\Models\PreguntaEncuesta;
use App\Models\DatosEncuesta;
use App\Models\GrupoInteres;
use App\Models\CargoAdministrativo;
use Carbon\Carbon;
use Exception;

class EncuestasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $id_encuesta = Encuesta::where('FK_ECT_Proceso',$id)->first();
        $grupos = PreguntaEncuesta::whereHas('grupos', function ($query) {
            return $query->where('FK_GIT_Estado','=' ,'1');
        })
        ->where('FK_PEN_Banco_Encuestas',$id_encuesta->FK_ECT_Banco_Encuestas)
        ->get()->pluck('grupos.GIT_Nombre', 'grupos.PK_GIT_Id');
        $cargos = CargoAdministrativo::all()->pluck('CAA_Cargo','PK_CAA_Id');
        return view('public.Encuestas.index',compact('grupos','cargos'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_proceso, $id_grupo, $id_cargo)
    {
        session()->put('pk_cargo', $id_cargo);
        session()->put('pk_encuesta', $id_proceso);
        session()->put('pk_grupo', $id_grupo);
        $id_encuesta = Encuesta::where('FK_ECT_Proceso',$id_proceso)->first();
        $preguntas = PreguntaEncuesta::whereHas('preguntas.respuestas', function ($query) {
            return $query->where('FK_PGT_Estado', '1');
        })
        ->with('preguntas.respuestas')
        ->where('FK_PEN_GrupoInteres', '=', $id_grupo)
        ->where('FK_PEN_Banco_Encuestas', '=', $id_encuesta->FK_ECT_Banco_Encuestas)
        ->get();
        $datos = DatosEncuesta::whereHas('grupos', function ($query) use($id_grupo) {
            return $query->where('PK_GIT_Id', '=',$id_grupo);
        })->first();
        return view('public.Encuestas.encuestas',compact('preguntas','datos'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SolucionEncuestaRequest $request)
    {
        $id_encuesta = Encuesta::where('FK_ECT_Proceso','=',session()->get('pk_encuesta'))
        ->first();
        $encuestados = new Encuestado();
        $encuestados->ECD_FechaSolucion = Carbon::now();
        $encuestados->FK_ECD_Encuesta = $id_encuesta->PK_ECT_Id;
        $encuestados->FK_ECD_GrupoInteres = session()->get('pk_grupo');
        if(session()->get('pk_grupo') != 3)
            $encuestados->FK_ECD_CargoAdministrativo = null;
        else
            $encuestados->FK_ECD_CargoAdministrativo = session()->get('pk_cargo');
        $encuestados->save();
        $preguntas = PreguntaEncuesta::whereHas('preguntas', function ($query) {
            return $query->where('FK_PGT_Estado', '1');
        })
        ->with('preguntas')
        ->where('FK_PEN_GrupoInteres', '=', session()->get('pk_grupo'))
        ->where('FK_PEN_Banco_Encuestas', '=', $id_encuesta->FK_ECT_Banco_Encuestas)
        ->get();
        foreach($preguntas as $pregunta){
                $valor = $request->get($pregunta->preguntas->PK_PGT_Id,false);
                $respuesta_encuesta = new SolucionEncuesta();
                $respuesta_encuesta->FK_SEC_Respuesta = $valor;
                $respuesta_encuesta->FK_SEC_Encuestado = $encuestados->PK_ECD_Id;
                $respuesta_encuesta->save();
        }           
        return response(['msg' => 'Proceso finalizado correctamente.',
            'title' => '¡Gracias por su contribución!'
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
}
