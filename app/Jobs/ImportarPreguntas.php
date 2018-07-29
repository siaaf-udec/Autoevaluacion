<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Caracteristica;
use App\Models\Factor;
use App\Models\PonderacionRespuesta;
use App\Models\Pregunta;
use App\Models\Proceso;
use App\Models\RespuestaPregunta;
use App\Models\TipoRespuesta;
use Excel;
use Illuminate\Support\Facades\Storage;

class ImportarPreguntas implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    protected $url_archivo, $id_proceso;
    public function __construct($url_archivo, $id_proceso)
    {
        $this->url_archivo = $url_archivo;
        $this->id_proceso = $id_proceso;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $id_proceso = $this->id_proceso;
            Excel::selectSheets('TIPO', 'PONDERACION', 'PREGUNTA', 'RESPUESTA')->load(public_path($this->url_archivo), function ($reader) use($id_proceso) {
                $sheets = $reader->all()->toArray();

                $tipo_respuesta = [];

                $count = count($sheets);
                if ($count <= 4 and $count > 0) {
                    //Tipo respesta
                    foreach ($sheets[0] as $row) {
                        $tipoRespuesta = new TipoRespuesta();
                        $tipoRespuesta->TRP_TotalPonderacion = $row['total_ponderacion'];
                        $tipoRespuesta->TRP_CantidadRespuestas = $row['cantidad_respuestas'];
                        $tipoRespuesta->TRP_Descripcion = $row['descripcion'];
                        $tipoRespuesta->FK_TRP_Estado = 1;
                        $tipoRespuesta->save();
                        $tipo_respuesta[$row['numero_tipo_respuesta']] = $tipoRespuesta->PK_TRP_Id;
                    }
                }
                if ($count <= 4 and $count > 1) {
                    //Ponderaciones
                    $ponderaciones = [];
                    foreach ($sheets[1] as $row) {
                        $ponderacion = new PonderacionRespuesta();
                        $ponderacion->PRT_Ponderacion = $row['ponderacion'];
                        $ponderacion->FK_PRT_TipoRespuestas = $tipo_respuesta[$row['tipo_respuesta']];
                        $ponderacion->save();
                        $ponderaciones[$row['numero_ponderacion']] = $ponderacion->PK_PRT_Id;
                    }
                }
                $lineamiento = Proceso::select('FK_PCS_Lineamiento')
                ->where('PK_PCS_Id', '=', $id_proceso)
                ->first();
                $caracteristicas = Caracteristica::whereHas('factor',function($query) use($lineamiento){
                    return $query->where('FK_FCT_Lineamiento',$lineamiento->FK_PCS_Lineamiento);
                })
                ->select('PK_CRT_Id', 'CRT_Identificador')
                ->get();

                if ($count <= 4 and $count > 3) {
                    //Preguntas
                    $preguntas = [];
                    foreach ($sheets[2] as $row) {
                        $pregunta = new Pregunta();
                        $pregunta->PGT_Texto = $row['pregunta'];
                        $pregunta->FK_PGT_Estado = 1;
                        $pregunta->FK_PGT_TipoRespuesta = $tipo_respuesta[$row['tipo_respuesta']];
                        $id = $caracteristicas->where('CRT_Identificador', $row['numero_caracteristica'])->first();
                        
                        $pregunta->FK_PGT_Caracteristica = $id->PK_CRT_Id;

                        $pregunta->save();
                        $preguntas[$row['numero_pregunta']] = $pregunta->PK_PGT_Id;
                    }
                }
                if ($count == 4) {
                    foreach ($sheets[3] as $row) {
                        $respuesta = new RespuestaPregunta();
                        $respuesta->RPG_Texto = $row['respuesta'];
                        $respuesta->FK_RPG_Pregunta = $preguntas[$row['numero_pregunta']];
                        $respuesta->FK_RPG_PonderacionRespuesta = $ponderaciones[$row['numero_ponderacion']];
                        $respuesta->save();
                    }
                }
            });
        }
        catch (\Exception $e) {
            
        }finally {
            $ruta = str_replace('storage', 'public', $this->url_archivo);
            Storage::delete($ruta);
        }
    }
}
