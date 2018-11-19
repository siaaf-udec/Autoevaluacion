<?php

namespace App\Http\Controllers\SuperAdministrador;

use App\Http\Controllers\Controller;
use DataTables;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class SeguridadController extends Controller
{
    /**
     * Permisos asignados en el constructor del controller para poder controlar las diferentes
     * acciones posibles en la aplicación como los son:
     * Acceder, ver, crea, modificar, eliminar
     */
    public function __construct()
    {
        // $this->middleware('permission:ACCEDER_SEGURIDAD');
    }
    public function index()
    {
        return view('autoevaluacion.SuperAdministrador.Seguridad.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax() && $request->isMethod('GET')) {
            $seguridad = Activity::all();
            return DataTables::of($seguridad)
                ->removeColumn('updated_at')
                ->addColumn('tabla', function ($seguridad) {
                    return substr($seguridad->subject_type, 26);
                })
                ->addColumn('usuario', function ($seguridad) {
                    return $seguridad->causer->email;
                })
                
                ->addColumn('antes', function ($seguridad) {
                    $json = explode(',', $seguridad->properties);
                    if($seguridad->description == 'deleted'){
                        return $json[0];
                    }
                    if(count($json) == 2){
                        $data = $json[1];
                        return $data;
                    }
                    
                    return '';
                })
                ->addColumn('despues', function ($seguridad) {
                    if ($seguridad->description == 'deleted') {
                        return '';
                    }
                    $json = explode(',', $seguridad->properties);
                    return $json[0];
                })
                ->rawColumns(['antes, despues'])
                ->make(true);
        }
    }
}
