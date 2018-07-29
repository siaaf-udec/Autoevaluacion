<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Proceso;
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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
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
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
