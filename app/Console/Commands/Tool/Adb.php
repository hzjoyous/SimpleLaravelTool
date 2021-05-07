<?php

namespace App\Console\Commands\Tool;

use Illuminate\Console\Command;

class Adb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:adb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $adbPath = config('simple.adbPath');

        $adbVersion = `$adbPath version`;
        $adbScreenCap = `$adbPath shell screencap -p /sdcard/01.png`;
        $adbPullScreenCap = `$adbPath pull `;
        $this->info($adbVersion);
        dump($adbScreenCap, $adbPullScreenCap);

        $map = [
          ['hCar','hHouse','hX','hS','h']
        ];
        return 0;
    }
}
