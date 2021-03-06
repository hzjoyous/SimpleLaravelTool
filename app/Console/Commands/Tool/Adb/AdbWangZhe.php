<?php

namespace App\Console\Commands\Tool\Adb;

use Illuminate\Console\Command;

class AdbWangZhe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:wangzhe';

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
     * @return mixed
     */
    public function handle()
    {
        $adbPath = config('simple.adbPath');
        $stops = [];
        $standardL = 2280;
        $standardW = 1080;
        $l = 2280 / $standardL;
        $w = 1080 / $standardW;
        $l = $w = 1;
        $stopl1 = (int)(951 * $l);
        $stopw1 = (int)(966 * $w);
        $stopl2 = (int)(1385 * $l);
        $stopw2 = (int)(711 * $w);
        $stopl3 = (int)(1970 * $l);
        $stopw3 = (int)(990 * $w);
        $stopl4 = (int)(1620 * $l);
        $stopw4 = (int)(880 * $w);


        $stops['成就确认  '] = "$adbPath   shell input tap $stopl1 $stopw1";
        $stops['三小时确认'] = "$adbPath   shell input tap $stopl2 $stopw2";
        $stops['开始挑战  '] = "$adbPath   shell input tap $stopl3 $stopw3";
        $stops['闯关      '] = "$adbPath   shell input tap $stopl4 $stopw4";
        while (true) {
            foreach ($stops as $stopName => $stop) {
                $this->info($stop);
                $result = exec($stop);
                $this->info($stopName . ':');
                $this->info($result);
            }
            $runTime = (microtime(true) - LARAVEL_START);
            $this->info('运行时长' . $runTime);
            if ((int)($runTime / 60) > 180) {
                break;
            }
        }

        $this->info("finish");
        return;
    }
}
