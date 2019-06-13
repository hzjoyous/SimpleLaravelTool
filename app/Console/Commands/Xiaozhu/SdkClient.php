<?php

namespace App\Console\Commands\XiaoZhu;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class SdkClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xiaozhu:client';

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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        dd();
        $client   = new Client([
            'base_uri'    => 'http://service-main.xiaozhu.com',
            'timeout'     => 10.0,
            'http_errors' => false,
        ]);
        $response = $client->request('get', '/CouponAccount/drawBackAccount4Refund', [
//            'from_params' => [
//                'bookOrderId' => 'qwe',
//                'remark'      => '',
//            ],
//            'headers' => [
//                'Content-type' => 'application/json',
//            ],
            'query' => [
                'bookOrderId' => '57824859',
                'remark'      => '562748901',
            ]
        ]);

        $this->line($response->getBody());
        return;
    }
}
