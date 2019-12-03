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
        /** xxxxxx */
        /** xxxx******** */
        /**xxxx******25 */
        $pre = 'xxx';
        $preList = [
            '0533',
            '0643',
            '1533',
            '1533',
            '1553',
            '1563',
            '1563',
            '1563',
            '1573',
            '1583',
            '1593',
            '2448',
            '2448',
            '2449',
            '3470',
            '3471',
            '3472',
            '3473',
            '3474',
            '3475',
            '3476',
            '3477',
            '3478',
            '3479',
            '5032',
            '5033',
            '5034',
            '5330',
            '5331',
            '5332',
            '5333',
            '5334',
            '5335',
            '5336',
            '5337',
            '5338',
            '5339',
            '5339',
            '5339',
            '6602',
            '6603',
            '6636',
            '6643',
            '6653',
            '6653',
            '6670',
            '8900',
            '8901',
            '8902',
            '8903',
            '8903',
            '8904',
            '8905',
            '8905',
            '8906',
            '8907',
            '8907',
            '8907',
            '8908',
            '8909',
            '8929',
            '8930',
            '8930',
            '8931',
            '8931',
            '8932',
            '9233',
            '9540',
            '9540',
            '9541',
            '9542',
            '9543',
            '9544',
            '9544',
            '9545',
            '9545',
            '9546',
            '9547',
            '9547',
            '9548',
            '9549',
            '9805',
            '9806',
            '9806',
        ];
        $last = 'xx';
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
