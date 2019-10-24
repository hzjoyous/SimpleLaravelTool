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

        /** sikuquanshu123@163.com */
        /** 642599786 */
        /** 152******** */
        /**152******25 */
        $pre = '';
        $preList = [];
        $last = '25';
        $tmpPath = storage_path('tmp');
        $now     = '';
        $vcfStr  = '';
        foreach ($preList as $preItem) {
            for ($j = 0; $j <= 9; $j++) {
                for ($i = 0; $i <= 9; $i++) {
                    $phoneNum = $pre . $preItem . (string) $j . (string) $i . $last;
                    $now .= $phoneNum . ',' . PHP_EOL;
                    $vcfStr .= "BEGIN:VCARD
VERSION:2.1
N:;$phoneNum;;;
FN:$phoneNum
TEL;CELL:$phoneNum
END:VCARD
";
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
