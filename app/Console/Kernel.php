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
        \App\Console\Commands\ClearBasketCommand::class,
        \App\Console\Commands\MakeImportCommand::class,
        \App\Console\Commands\MakeUpdateCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('clear_basket')
            ->dailyAt('04:00');

        $schedule->command('import')
            ->hourly();

        $schedule->command('update')
            ->hourly();
    }
}
