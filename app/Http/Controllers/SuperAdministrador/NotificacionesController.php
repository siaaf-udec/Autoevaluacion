<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use App\Models\Autoevaluacion\ActividadesMejoramiento;
use Carbon\Carbon;

class NotificacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actividades = ActividadesMejoramiento::where('ACM_Fecha_Fin', '<=', Carbon::now()->addDay(2))
            ->where('ACM_Fecha_Fin', '>=', Carbon::now())
            ->get();
        $datos['notificaciones'] = $actividades;
        return json_encode($datos);
    }
}
