<?php

namespace App\Http\Controllers\SuperAdministrador;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Proceso;

class pageController extends Controller
{
    public function index(){
        return view('admin.dashboard.index');
    }

    public function mostrarProcesos()
    {
        $procesos_usuario = Auth::user()->procesos()->with('programa.sede')->get()
        ->mapWithKeys(function ($i) {
            $sede = 'Institucional';
            if(isset($i->programa->sede->SDS_Nombre)){
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
        if(isset($proceso->programa->sede->SDS_Nombre)){
            $sede = $proceso->programa->sede->SDS_Nombre;
        }
        $procesoSede = $sede . ' ' . $proceso->PCS_Nombre;
        session(['proceso' => $procesoSede]);
        session(['id_proceso' => $request->get('PK_PCS_Id')]);
        return redirect()->back();
    }
    
}
