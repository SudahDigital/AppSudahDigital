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
        // $schedule->command('inspire')->hourly();
        /*$schedule->call(function () {
            \App\Order::with('products')
                ->where('status', 'SUBMIT')
                ->whereNull('customer_id')
                ->where('created_at', '<=', now()->subMinutes(30)->toDateTimeString())
                ->delete();
        })->everyMinute();*/
        $schedule->call('App\Http\Controllers\SendReportDailyController@index')->daily()->at('13:00');
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
