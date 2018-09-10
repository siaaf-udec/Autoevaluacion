<?php

namespace App\Console;

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
        $schedule->call(function () {
            $proceso = new Proceso();
            $proceso->where('FK_PCS_Fase', '=', 1)
                ->where('PCS_FechaFin', '<', Carbon::now()->subMonths(3))
                ->delete();
        })->daily();

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
