<?php

namespace App\Console;

use App\Console\Commands\WorkerData\WorkerCategoryCommand;
use App\Console\Commands\WorkerData\WorkerCreateSiteMapCommand;
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
		WorkerCategoryCommand::class,
		WorkerCreateSiteMapCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
		if (app()->environment() !== 'local')
		{
			$this->runWorkerCommon($schedule);
		}
    }

    protected function runWorkerCommon(Schedule $schedule)
	{
		$schedule->command('worker:category-sync-data')->dailyAt('00:00');
		$schedule->command('sitemap:create')->dailyAt('1:00');
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
