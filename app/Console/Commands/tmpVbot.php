<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class tmpVbot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:vbot';

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
        $webHook = 'http://127.0.0.1:8866';

        $client = new Client([
            'base_uri' => $webHook,
            'timeout' => 10.0,
            'http_errors' => false,
        ]);
        $response = $client->request('post', '', [
            'json' => [
                "action" => "search",
                "params" => [
                    "type" => "groups",
                    "method" => "getObject",
                ]
            ]
        ]);

//        dd((string)$response->getBody());
        $data = json_decode($response->getBody(), true);
        dd($data);

    }
}
