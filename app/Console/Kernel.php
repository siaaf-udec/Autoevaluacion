<?php

namespace App\Console;

use App\Models\Autoevaluacion\DocumentoAutoevaluacion;
use App\Models\Autoevaluacion\IndicadorDocumental;
use App\Models\Autoevaluacion\Lineamiento;
use App\Models\Autoevaluacion\RespuestaPregunta;
use App\Models\Historial\Caracteristica;
use App\Models\Historial\DocumentoProceso;
use App\Models\Historial\Factor;
use App\Models\Historial\Pregunta;
use function foo\func;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Autoevaluacion\Proceso;
use App\Models\Autoevaluacion\Encuesta;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     * Funciones que se ejecutan segun el intervalo de tiempo
     * definido
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /**
         * Schedule utilizado para comprobar si el proceso ya termino
         * si ya termino el estado cambia a 1 el cual significa cerrado
         */
        $schedule->call(function () {
            $proceso = new Proceso();
            $proceso->where('PCS_FechaFin', '<', Carbon::now())
                ->update(['FK_PCS_Fase' => 1]);
        })->daily();

        /**
         * Schedule usado para comprobar hace cuanto el proceso esta cerrado  si lleva
         * 3 meses cerrado se elimina
         */
        $schedule->call(/**
         *
         */
            function () {
            $proceso = new Proceso();
            $proceso = $proceso->where('FK_PCS_Fase', '=', 1)
                ->where('PCS_FechaFin', '<', Carbon::now()->subMonths(3))
                ->get();

            /**
             * LLenar historial con el lieneamiento, factor, caractersitica, indicador
             */
            foreach ($proceso as $process) {
                $caracteristicas = [];
                $indicadores = [];
                $preguntas = [];


                /**
                 * Para las graficas documentales
                 */
                $indicadores_documentales = IndicadorDocumental::whereHas('caracteristica.factor', function ($query) use ($process) {
                    $query->where('FK_FCT_Lineamiento', '=', $process->FK_PCS_Lineamiento);
                })
                    ->with('documentosAutoevaluacion', 'caracteristica')
                    ->get();
                $documentosAux = DocumentoAutoevaluacion::with('indicadorDocumental')
                    ->where('FK_DOA_Proceso', '=', $process->PK_PCS_Id)
                    ->oldest()
                    ->get();

                $documentos = $documentosAux->groupBy('FK_DOA_IndicadorDocumental');



                $lineamientos_autoevaluacion = Lineamiento::with('factor_.caracteristica.indicadores_documentales')
                    ->where('PK_LNM_Id', '=', $process->FK_PCS_Lineamiento)
                    ->get();

                $lineamiento_historial = new \App\Models\Historial\Lineamiento();
                $lineamiento_historial->LNM_Nombre = $lineamientos_autoevaluacion[0]->LNM_Nombre;
                $lineamiento_historial->save();
                

                $proceso_historial = new \App\Models\Historial\Proceso();
                $proceso_historial->PCS_Nombre = $process->nombre_proceso;
                $proceso_historial->PCS_Completitud_Documental = (($documentos->count() / $indicadores_documentales->count()) * 100);
                $proceso_historial->FK_PCS_Lineamiento = $lineamiento_historial->PK_LNM_Id;
                $proceso_historial->PCS_Anio_Proceso = $process->PCS_FechaInicio;
                $proceso_historial->save();

                foreach ($lineamientos_autoevaluacion[0]->factor_ as $factor) {
                    $factor_historial = new Factor();
                    $factor_historial->FCT_Nombre = $factor->FCT_Identificador . '.' . $factor->FCT_Nombre;
                    $factor_historial->FK_FCT_Lineamiento = $lineamiento_historial->PK_LNM_Id;
                    $factor_historial->save();

                    foreach ($factor->caracteristica as $caracteristica) {
                        $caracteristica_historial = new Caracteristica();
                        $caracteristica_historial->CRT_Nombre = $caracteristica->CRT_Identificador . '.' . $caracteristica->CRT_Nombre;
                        $caracteristica_historial->FK_CRT_Factor = $caracteristica->FK_CRT_Factor;
                        $caracteristica_historial->save();

                        $caracteristicas[$caracteristica->PK_CRT_Id] = $caracteristica_historial->PK_CRT_Id;

                        foreach ($caracteristica->indicadores_documentales as $indicador_documental) {
                            $indicador_documental_historial = new \App\Models\Historial\IndicadorDocumental();
                            $indicador_documental_historial->IDO_Nombre = $indicador_documental->IDO_Nombre;
                            $indicador_documental_historial->FK_IDO_Caracteristica = $caracteristica_historial->PK_CRT_Id;
                            $indicador_documental_historial->save();
                            $indicadores[$indicador_documental->PK_IDO_Id] = $indicador_documental_historial->PK_IDO_Id;
                        }
                    }
                }

                $documentos_autoevaluacion = DocumentoAutoevaluacion::all()
                    ->where('FK_DOA_Proceso', '=', $process->PK_PCS_Id);



                foreach ($documentos_autoevaluacion as $documento){
                    $documentos_historial = new DocumentoProceso();
                    $documentos_historial->DPC_Fecha_Subida = $documento->created_at;
                    $documentos_historial->FK_DPC_Proceso = $proceso_historial->PK_PCS_Id;
                    $documentos_historial->FK_DPC_Indicador = $indicadores[$documento->FK_DOA_IndicadorDocumental];
                    $documentos_historial->save();
                }

                $preguntas_autoevaluacion = \App\Models\Autoevaluacion\Pregunta::whereHas('caracteristica.factor', function ($query) use($lineamientos_autoevaluacion){
                    $query->where('FK_FCT_Lineamiento', $lineamientos_autoevaluacion[0]->PK_LNM_Id);
                })
                ->get();



                foreach ($preguntas_autoevaluacion as $pregunta){
                    $preguntas_historial = new Pregunta();
                    $preguntas_historial->PGT_Texto = $pregunta->PGT_Texto;
                    $preguntas_historial->FK_PGT_Caracteristica = $caracteristicas[$pregunta->FK_PGT_Caracteristica];
                    $preguntas_historial->save();

                    $preguntas[$pregunta->PK_PGT_Id] = $preguntas_historial->PK_PGT_Id;
                }

                $respuestas_autoevaluacion = RespuestaPregunta::whereHas('pregunta.caracteristica.factor', function ($query) use($lineamientos_autoevaluacion){
                    $query->where('FK_FCT_Lineamiento', $lineamientos_autoevaluacion[0]->PK_LNM_Id);
                })
                    ->get();

                foreach ($respuestas_autoevaluacion as $respuestas) {
                    $respuestas_historial = new \App\Models\Historial\RespuestaPregunta();
                    $respuestas_historial->RPG_Texto = $respuestas->RPG_Texto;
                    $respuestas_historial->FK_RPG_Pregunta = $preguntas[$respuestas->FK_RPG_Pregunta];
                    $respuestas_historial->save();
                }

                //$process->delete();
            }
        })->everyMinute();

        /**
         * Schedule usado para comprobar la fecha en la que inicia la
         * encuesta relacionada con el proceso, si ya inicio la coloca en fase 4
         * la cual significa recolección de datos
         */

        $schedule->call(function () {
            $proceso = Proceso::whereHas('encuestas', function ($query) {
                return $query->where('ECT_FechaPublicacion', '<=', Carbon::now());
            })
                ->where('FK_PCS_Fase', '!=', '1')
                ->update(['FK_PCS_Fase' => 4]);
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
