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
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $proceso = new Proceso();
            $proceso->where('PCS_FechaFin', '<', Carbon::now())
                ->update(['FK_PCS_Fase' => 1]);
        })->daily();

        $schedule->call(function () {
            $proceso = new Proceso();
            $proceso->where('FK_PCS_Fase', '=', 1)
                ->where('PCS_FechaFin', '<', Carbon::now()->subMonths(2))
                ->delete();
        })->daily();

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
