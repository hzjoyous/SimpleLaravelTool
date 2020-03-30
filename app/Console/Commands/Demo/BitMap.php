<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;

class BitMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:bitMap';

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
     * @var \Redis
     */
    private $redis;

    private $cacheKey = 'dev:test:bitmap';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $redisHost     = '10.0.2.222';
        $redisPassWord = '9f83d4682ba8b962';
        $redisPort     = 6379;


        $redis = new \Redis();
        $redis->connect($redisHost, $redisPort);
        $redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);
        $redisPassWord && $redis->auth($redisPassWord);
        $cacheKey = $this->cacheKey;

//        for ($i = 1; $i < 100000; $i++) {
//            $redis->setBit($cacheKey, $i, 1);
//            echo $i . PHP_EOL;
//
//        }

        $maxOffSet = 4294967296;
//        var_dump($maxOffSet+1);
//        $result = $redis->setBit($cacheKey,$maxOffSet-1 , 1);
        $redis->setBit($cacheKey, 7, 0);

        // 高危函数。。。 如果值很小调用get 没有问题，如果值很大，则会出现没有反应的情况
        //$result = $redis->get($cacheKey);
        $result = $redis->getbit($cacheKey, 13000);

        $start = microtime(true);
        sleep(1);

        echo (microtime(true) - $start) . PHP_EOL;
        $start = microtime(true);
        $result = $redis->bitCount($cacheKey);
        echo (microtime(true) - $start) . PHP_EOL;
        #$result = $redis->bitOp($cacheKey);

        return ;

    }
}
