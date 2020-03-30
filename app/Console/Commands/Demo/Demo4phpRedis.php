<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;
use Redis;

class Demo4phpRedis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:phpredis';

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
        // ext-redis https://github.com/phpredis/phpredis   
        
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);

        $result = $redis->lPush('key1', 'A');
        dump($result);

        $result = $redis->lPop('key1');
        dump($result);

    }
}
