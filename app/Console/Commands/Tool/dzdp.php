<?php

namespace App\Console\Commands\Tool;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class dzdp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:dzdp';

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
        $client = new Client([
            'base_uri'    => 'http://www.dianping.com/shop/6441579/review_all/',
            'timeout'     => 10.0,
            'http_errors' => false,
        ]);
        $body   = '';

        for ($i = 2; $i <= 103; $i++) {
            $this->info($i);
            $response = $client->request('get', '/p'.(string)$i, [
                'query' => [
                    'queryType' => 'isAll',
                    'queryVal'  => 'true'
                ]
            ]);
            sleep(1);
            $body = (string)($response->getBody());
            $tmpPath = storage_path('tmp');
            $inputFileName = $tmpPath . '/dzdpbody.log';
            file_put_contents($inputFileName, $body,8);
        }

        return;
    }
}
