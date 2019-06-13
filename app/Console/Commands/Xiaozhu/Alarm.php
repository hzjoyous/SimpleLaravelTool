<?php

namespace App\Console\Commands\Xiaozhu;

use Illuminate\Console\Command;

class Alarm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xiaozhu:test_alarm';

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

        $order            = 'mysql.production';
        $sql              = <<<eof
select submiterid,id,createtime
from bookorder.bookorder
where createtime > '2019-03-15 01:58:01'
  and createtime < '2019-03-15 04:01:01'
  and submiterid not in (
                         97515911101,
                         97515911107,
                         97515911113,
                         97515911119,
                         97515911125,
                         97515911131,
                         97515911137,
                         97515911143,
                         97515911149,
                         97515911155
  )
eof;
        $oResult          = \DB::connection($order)->select($sql);
        $xzOrderIdPath    = storage_path('/tmp/');
        $xzOrderIdFile    = $xzOrderIdPath . 'checkOrderIds' . date('Y-m-d') . '.json';
        $xzOrderIdBakFile = $xzOrderIdPath . 'checkOrderIds' . date('Y-m-d') . '.bak';

        $oResult = array_map(function ($item) {
            return ['id' => $item->id, 'submiterid' => $item->submiterid, 'createtime' => $item->createtime];
        }, $oResult);
        $oResult = array_column($oResult, null, 'id');

        if (!is_dir($xzOrderIdPath)) {
            mkdir($xzOrderIdPath, 0777, 1);
        }

        $checkedOrderIds = [];

        if (is_file($xzOrderIdFile)) {
            $checkedOrderIds = file_get_contents($xzOrderIdFile);
            $checkedOrderIds = json_decode($checkedOrderIds, 1);
            if (!$checkedOrderIds) {
                $checkedOrderIds = [];
            }
            $checkedOrderIds = array_column($checkedOrderIds, null, 'id');
        }


        $newOResult = array_filter($oResult, function ($item) use ($checkedOrderIds) {
            return !isset($checkedOrderIds[$item['id']]);
        });


        $checkedOrderIds = array_merge($newOResult, $checkedOrderIds);
        $checkedOrderIds = array_column($checkedOrderIds, null, 'id');

        $bakData = '';
        foreach ($newOResult as $orderId => $item) {
            $bakData .= ('orderId:' . $orderId . '|' . 'submitterId:' . $item['submiterid']) . PHP_EOL;
        }
        file_put_contents($xzOrderIdBakFile, $bakData, 8);
        file_put_contents($xzOrderIdFile, json_encode($checkedOrderIds));

        dd($newOResult);

        return;
    }
}
