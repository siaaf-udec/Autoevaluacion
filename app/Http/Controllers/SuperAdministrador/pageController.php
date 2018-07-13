<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Models\Proceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class pageController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function mostrarProcesos()
    {
        $ejemplo = Auth::user()->procesos()->with('programa.sede')->get();
        $procesos_usuario = Auth::user()->procesos()->with('programa.sede')->get()
            ->mapWithKeys(function ($i) {
                $sede = 'Institucional';
                if (isset($i->programa->sede->SDS_Nombre)) {
                    $sede = $i->programa->sede->SDS_Nombre;
                }
                return [$i['PK_PCS_Id'] => $sede . ' ' . $i['PCS_Nombre']];
            });
        return json_encode($procesos_usuario);
    }

    public function seleccionarProceso(Request $request)
    {
        $proceso = new Proceso();
        $proceso = $proceso::findOrFail($request->get('PK_PCS_Id'));
        $sede = "Institucional";
        if (isset($proceso->programa->sede->SDS_Nombre)) {
            $sede = $proceso->programa->sede->SDS_Nombre;
        }
        $procesoSede = $sede . ' ' . $proceso->PCS_Nombre;
        session(['proceso' => str_limit($procesoSede, 50, '...')]);
        session(['id_proceso' => $request->get('PK_PCS_Id')]);
        return redirect()->back();
    }

}
