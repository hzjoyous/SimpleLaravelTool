<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class T extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:t';

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
        $list          = [5, 14, 31];
        $nowMonth      = (int)date('m');
        $nowYear       = (int)date('Y');
        $i             = 0;
        while (1) {
            $nowDay = $list[$i % 3];
            if ($nowDay == date('d', strtotime("$nowYear-" .
                    str_pad($nowMonth, 2, "0", STR_PAD_LEFT) . "-" .
                    str_pad($nowDay, 2, "0", STR_PAD_LEFT)))) {
                echo date('Y-m-d', strtotime("$nowYear-" .
                    str_pad($nowMonth, 2, "0", STR_PAD_LEFT) . "-" .
                    str_pad($nowDay, 2, "0", STR_PAD_LEFT)));
                echo PHP_EOL;
            } else {
                echo date('Y-m-01', strtotime("$nowYear-" .
                    str_pad($nowMonth, 2, "0", STR_PAD_LEFT) . "-" .
                    str_pad($nowDay, 2, "0", STR_PAD_LEFT)));
                echo PHP_EOL;
            }
            $i++;
            if($i%3==0){
                $nowMonth++;
            }
            if($nowMonth%13==0){
                $nowMonth=1;
                $nowYear+=1;
            }
            if($i>100){
                break;
            }
        }

        return 0;
    }

}
