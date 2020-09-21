<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\commands\SendAlertes',
        'App\Console\commands\SendNewsletter',
        'App\Console\commands\UpdateArrets',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('update:arret')->daily()->at('13:45');
        $schedule->command('send:alert daily')->daily()->at('14:15');
        $schedule->command('send:alert weekly')->weekly()->fridays()->at('14:30');
        $schedule->command('send:newsletter')->mondays()->at('15:00');
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
