<?php

namespace App\Console\Commands\Tool\Adb;

use Illuminate\Console\Command;

class AdbDouYin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:douyin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     *   anyproxy -i
     *   anyproxy -i  -r douyin.js
     *
     *   C:\Users\HZJ\AppData\Local\Android\Sdk\platform-tools\adb.exe connect 127.0.0.1:21503
     *
     *   grep -h -r 'signature' /mnt/c/Users/HZJ/.anyproxy/cache/> signature.1329.log
     *
     *   unique_id
     *   owner_handle
     */

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $adbPath = config('simple.adbPath');

        $adbVersion = `$adbPath version`;
        $this->info($adbVersion);

        $standardH =  1440;
        $standardW = 960;

        $start = new Coordinate();
        $start->x = $standardW / 2;
        $start->y = (int) ($standardH / 7 * 4);

        $end = new Coordinate();
        $end->x = $standardW / 2;
        $end->y = (int) ($standardH / 7);


        while (true) {
            exec("{$adbPath} shell input swipe {$start->x} {$start->y} {$end->x} {$end->y}");
            $runTime = (microtime(true) - LARAVEL_START);
            $this->info('运行时长:' . $runTime);
        }
        return ;
    }
}
