<?php

namespace App\Console\Commands\Tool;

use Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;

class Demo4es extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:es';

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

        // composer https://packagist.org/packages/elasticsearch/elasticsearch
        // docs https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/index.html

        // $hosts = [
        //     '192.168.1.1:9200',         // IP + Port
        //     '192.168.1.2',              // Just IP
        //     'mydomain.server.com:9201', // Domain + Port
        //     'mydomain2.server.com',     // Just Domain
        //     'https://localhost',        // SSL to localhost
        //     'https://192.168.1.3:9200'  // SSL to IP + Port
        // ];

        $hosts = [
            "localhost:9200"
        ];

        $client = ClientBuilder::create()
            ->setHosts($hosts)
            ->build();

        $params = [
            'index' => 'my_index',
            'id'    => 'my_id',
            'body'  => ['testField' => 'abc']
        ];

        $response = $client->index($params);
        print_r($response);
        
    }
}
