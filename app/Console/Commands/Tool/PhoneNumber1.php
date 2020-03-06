<?php

namespace App\Console\Commands\Tool;

use Illuminate\Console\Command;

class PhoneNumber1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:phone';

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
     * 155********
     *
     */

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** xxxxxxxxxxx@163.com */
        /** 1031968934 */
        /** 237123603 */
        /** xxxx******** */
        /** xxxx******25 */
        /**
         * 孙瑞君
         */
        /** @var  $pre */
        $pre = '178';
        $preList = ['1234'];
        $last = '06';
        $tmpPath = storage_path('tmp');
        $now = '';
        $vcfStr = '';

        $vsfStrList = '';

        $num = 0;
        foreach ($preList as $preItem) {
            for ($j = 0; $j <= 9; $j++) {
                for ($i = 0; $i <= 9; $i++) {
                    $phoneNum = $pre . $preItem . (string)$j . (string)$i . $last;
                    $now .= $phoneNum . ',' . PHP_EOL;
                    $vcfStr .= <<<EOF

BEGIN;
BEGIN:VCARD
VERSION:2.1
N:;$phoneNum;;;
FN:$phoneNum
TEL;CELL:$phoneNum
END:VCARD
EOF;

                    $vsfStrList .= <<<EOF

BEGIN;
BEGIN:VCARD
VERSION:2.1
N:;z$phoneNum;;;
FN:z$phoneNum
TEL;CELL:$phoneNum
END:VCARD
EOF;
                    $num++;
                    if ($num === 3000) {
                        $inputFileName = $tmpPath . "/phone$phoneNum.vcf";
                        file_put_contents($inputFileName, $vsfStrList);
                        $vsfStrList = '';
                        $num = 0;
                    }

                }
            }
        }
        $inputFileName = $tmpPath . '/phone.csv';
        file_put_contents($inputFileName, $now);
        $inputFileName = $tmpPath . '/phone.vcf';
        file_put_contents($inputFileName, $vcfStr);

        return;
    }
}
