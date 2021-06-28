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
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $logDir = storage_path('logs');

        file_exists($logDir) || mkdir($logDir, 0666, true);
        $logPath = $logDir . DIRECTORY_SEPARATOR . 'laravel.log';

        $schedule->call(function () {
            echo date('Y-m-d H:i:s') . ' from once job' . PHP_EOL;
        })->cron('* * * * *');

        $schedule
            ->command('time')
            // output 重定向
            ->sendOutputTo($logPath, true)
            // 后台运行（避免阻塞）
            ->runInBackground()
            // 加锁执行
            ->withoutOverlapping()
            ->everyMinute();
            // 每30分钟一次
//            ->everyThirtyMinutes();
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
