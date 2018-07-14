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
