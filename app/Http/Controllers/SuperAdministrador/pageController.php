<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\Proceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Autoevaluacion\DocumentoAutoevaluacion;
use App\Models\Autoevaluacion\IndicadorDocumental;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\Dependencia;
use App\Models\Autoevaluacion\TipoDocumento;
use App\Models\Autoevaluacion\GrupoDocumento;
use App\Models\Autoevaluacion\DocumentoInstitucional;

use App\Models\Autoevaluacion\Encuesta;
use App\Models\Autoevaluacion\Encuestado;
use App\Models\Autoevaluacion\PreguntaEncuesta;
use App\Models\Autoevaluacion\RespuestaPregunta;
use App\Models\Autoevaluacion\Pregunta;
use App\Models\Autoevaluacion\GrupoInteres;
use App\Models\Autoevaluacion\Caracteristica;
use App\Models\Autoevaluacion\SolucionEncuesta;

class pageController extends Controller
{
    public function index()
    {
        if (Gate::allows('SUPERADMINISTRADOR')) {

            //Documental
            $id_lineamiento = Proceso::find(session()->get('id_proceso'))->FK_PCS_Lineamiento ?? null;

            $factores_documental = Factor::has('caracteristica.indicadores_documentales')
                ->where('FK_FCT_Lineamiento', '=', $id_lineamiento)
                ->where('FK_FCT_estado', '=', '1')
                ->get()
                ->pluck('nombre_factor', 'PK_FCT_Id');
            $dependencias = Dependencia::pluck('DPC_Nombre', 'PK_DPC_Id');

            $tipo_documentos = TipoDocumento::pluck('TDO_Nombre', 'PK_TDO_Id');

            //Encuestas
            $grupos = GrupoInteres::where('FK_GIT_Estado', '=', '1')
                ->get()->pluck('GIT_Nombre', 'PK_GIT_Id');
            $factores_encuestas = Factor::where('FK_FCT_Lineamiento', '=', $id_lineamiento)
                ->get()->pluck('nombre_factor', 'PK_FCT_Id');

            return view(
                'admin.dashboard.index',
                compact('factores_documental', 'dependencias', 'tipo_documentos', 'grupos', 'factores_encuestas')
            );
        }
        return view('admin.dashboard.index');
    }

    public function mostrarProcesos()
    {
        $ejemplo = Auth::user()->procesos()->with('programa.sede')->get();
        $procesos_usuario = Auth::user()->procesos()->with('programa.sede')->get()->pluck('nombre_proceso', 'PK_PCS_Id');
        return json_encode($procesos_usuario);
    }

    public function seleccionarProceso(Request $request)
    {
        $proceso = new Proceso();
        $proceso = $proceso::findOrFail($request->get('PK_PCS_Id'))->nombre_proceso;
        session(['proceso' => str_limit($proceso, 50, '...')]);
        session(['id_proceso' => $request->get('PK_PCS_Id')]);
        return redirect()->back();
    }

}
