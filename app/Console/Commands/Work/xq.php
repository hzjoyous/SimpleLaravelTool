<?php

namespace App\Console\Commands\Work;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

class xq extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:xq';

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

//        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
//        $spreadsheet = $reader->load(__DIR__.'/2345_buyu_210429.csv');
        $zgd  = function ($fileName) {
            return array_column(array_map(function ($item) {
                $item = str_getcsv($item);
                return [
                    'table_name'    => trim($item[0]),
                    'table_rows'    => $item[1],
                    'index_data'    => (float)$item[2],
                    'data_data'     => (float)$item[3],
                    'TABLE_COMMENT' => $item[4],
                    'CREATE_TIME'   => $item[5],
                    'UPDATE_TIME'   => $item[6] ?? 0,
                ];
            }, file($fileName)), null, 'table_name');
        };
        $d429 = $zgd(__DIR__ . 'Resource/2345_buyu_210429.csv');
        $d430 = $zgd(__DIR__ . 'Resource/2345_buyu_210430.csv');

        $changeData = array_reduce($d429, function ($pre, $item) use ($d430) {
            if(!array_key_exists("table_name",$item)){
                dump($item);
                return $pre;
            }
            if(!array_key_exists($item['table_name'],$d430)){

                $this->error($item['table_name']);
                return $pre;
            }
            $newDayItem = $d430[$item['table_name']];

            if (
                ($item['index_data'] != $newDayItem['index_data'])
                ||
                ($item['table_rows'] != $newDayItem['table_rows'])
                ||
                ($item['data_data'] != $newDayItem['data_data'])
                ||
                ($item['UPDATE_TIME'] != $newDayItem['UPDATE_TIME'])
            ) {
                $pre[] = [
                    'table_name'        => $item['table_name'],
                    'change_index_data' => (string)(float)($newDayItem['index_data'] - $item['index_data']),
                    'change_table_rows' => (string)(float)($newDayItem['table_rows'] - $item['table_rows']),
                    'change_data_data'  => (string)(float)($newDayItem['data_data'] - $item['data_data']),
                    'NEW_UPDATE_TIME'   => ($newDayItem['UPDATE_TIME']),

                ];
            }
            return $pre;
        }, []);
        $this->table([
            'table_name',
            'change_index_data',
            'change_table_rows',
            'change_data_data',
            'NEW_UPDATE_TIME',
        ], $changeData);
        dd();


        $basePath = 'C:\Users\HZJ\Desktop\work\project\h5.2345.com';
        $allPath  = [$basePath . DIRECTORY_SEPARATOR . 'app',
                     $basePath . DIRECTORY_SEPARATOR . 'console',
                     $basePath . DIRECTORY_SEPARATOR . 'src',
                     $basePath . DIRECTORY_SEPARATOR . 'web',];


//        dd(count((new Finder)->in($allPath)->files()));
        foreach ((new Finder)->in($allPath)->files() as $file) {

            if ($file->getExtension() != 'php') {
                continue;
            }


            if (stripos($file->getRealPath(), 'model') !== false) {

//                dump($file->getRealPath());
                dump(str_replace('C:\\Users\\HZJ\\Desktop\\work\\project\\h5.2345.com\\', '', $file->getRealPath()));
                $modelFile        = [$file->getRealPath()];
                $classFileContent = file_get_contents($file->getRealPath());
                $classFileContent = mb_convert_encoding($classFileContent, 'UTF-8', 'GBK');

            }


            continue;
        }
        return 0;
    }
}
