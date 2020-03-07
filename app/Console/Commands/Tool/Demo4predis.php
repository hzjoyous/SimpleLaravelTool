<?php

namespace App\Console\Commands\Tool;

use Illuminate\Console\Command;
use Predis\Client;

class Demo4predis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:predis';

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
        // composer https://packagist.org/packages/predis/predis
        // 
        $client = new Client([
            'scheme' => 'tcp',
            'host'   => '127.0.0.1',
            'port'   => 6379,
        ]);
        $result = $client->rpush('my:list', 'value1', 'value2', 'value3');            
        $result = $client->rpop('my:list');

        dump($result);

    }
}
