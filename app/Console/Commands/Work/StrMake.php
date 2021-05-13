<?php

namespace App\Console\Commands\Work;

use Illuminate\Console\Command;

class StrMake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:w:str';

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
        $this->buildDataSelectSql();
        return 0;
    }

    protected function buildDataSelectSql()
    {
        $m  = 5;
        /* 转为0起点，增长11，12取余，恢复1起点*/
        $startM = ((date('m')-1)+11)%12+1;
        if($startM<10){
            $startM = '0'.$startM;
        }
        $startTime = strtotime(date("Y-{$startM}-01"));
//        $startTime = strtotime(date('2021-01-15'));
        for($i = 0 ;$i<150;$i++){
            if(date('m',($startTime+86400*$i)) == 5){
                break;
            }
            $tableName = 'xq_gold_order_'.date('Y_m_d',($startTime+86400*$i));
            $date = date('Y-m-d',($startTime+86400*$i));
            $str = <<<EOF

select '{$date}' as p_dt,type,case when sub_gold>0 then '减少' else '增加' end,sum(sub_gold+add_gold)gold from {$tableName}
group by type,case when sub_gold>0 then '减少' else '增加' end

union 
EOF;
            echo $str;
        }
    }
}
