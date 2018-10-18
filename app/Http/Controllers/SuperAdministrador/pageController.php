<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\Dependencia;
use App\Models\Autoevaluacion\Factor;
use App\Models\Autoevaluacion\GrupoInteres;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\TipoDocumento;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        session(['proceso' => str_limit($proceso, 45, '...')]);
        session(['id_proceso' => $request->get('PK_PCS_Id')]);
        return redirect()->back();
    }

    public function pdf_reporte(Request $request)
    {
        $imagenes = explode('|', $request->get('json_datos'));
        $pdf = PDF::loadView('admin.dashboard.pdf_reporte_general', compact('imagenes'));
        return $pdf->download('reporte_general.pdf');
    }

}
