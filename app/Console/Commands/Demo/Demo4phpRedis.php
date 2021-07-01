<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;
use Redis;

class Demo4phpRedis extends Command
{
    /**
     * redis-cli
     * flushall
     */
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xdemo:phpredis';

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
     * @var Redis $redis
     */
    private $redis;
    private $redisHost = '127.0.0.1';
    private $redisPort = 6379;
    private $redisPassWord = '';
    private $redisStringKey;
    private $redisStringKeyValue;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // ext-redis https://github.com/phpredis/phpredis
        $this->info("This is Redis Demo by phpRedis");

        $this->redisInit();

        $this->redisStringDemo();
        $this->redisHashDemo();
        $this->redisListDemo();
        $this->redisSetDemo();
        $this->redisSortSetDemo();

        return;
    }

    private function redisInit()
    {

        $this->redis = new Redis();
        $this->redis->connect($this->redisHost, $this->redisPort);
        $this->redis->setOption(Redis::OPT_READ_TIMEOUT, -1);
        $this->redisPassWord && $this->redis->auth($this->redisPassWord);

        return;
    }

    private function redisStringDemo()
    {

        $this->output->title('redis string demo');
        $this->info("下面是redis string的简单操作(序列化、复杂查找、时间查询、单独时间设置这里不予列出)");

        $this->redisStringKey = 'redis:string:demo';
        $this->redis->set($this->redisStringKey, 'redisDemoValue', 2);

        while (true) {
            $this->redisStringKeyValue = $this->redis->get($this->redisStringKey);
            // 不存在时为false
            if ($this->redisStringKeyValue === false) {
                break;
            }
            $this->info($this->redisStringKeyValue);
            sleep(1);
        }

        $this->redis->set($this->redisStringKey, false);
        $this->redisStringKeyValue = $this->redis->get($this->redisStringKey);
        if ($this->redisStringKeyValue !== false) {
            $result = $this->redis->del($this->redisStringKey);
            dump($result);
            $this->info('删除成功返回结果为(int)1');
            $result = $this->redis->del($this->redisStringKey);
            dump($result);
            $this->info('删除失败返回结果为(int)0');
        }

        $this->output->title('redis string bitmap 应用demo');
        $this->info("Bit-map的基本思想就是用一个bit位来标记某个元素对应的Value，而Key即是该元素。由于采用了Bit为单位来存储数据，因此在存储空间方面，可以大大节省。（PS：划重点 节省存储空间）");
        $this->info("将{$this->redisStringKey}的前100000个插入数字");
        for ($i = 0; $i < 10000; $i++) {
            $this->redis->setBit($this->redisStringKey, $i, 1);
        }

        $this->info("对bitmap进行求和操作,可用于用户数据统计（如日活）");

        $result = $this->redis->getbit($this->redisStringKey, 1300);
        $this->info("\$this->redis->getbit(\$this->redisStringKey, 1300);  => {$result}");
        $result = $this->redis->bitCount($this->redisStringKey);
        $this->info("\$this->redis->bitCount(\$this->redisStringKey);=>{$result}");
        $result = $this->redis->del($this->redisStringKey);
        if ($result === 1) {
            $this->output->success('bitmap 运行完毕清除成功');
        }
        return;
    }

    private function redisHashDemo()
    {


        $this->output->title('redis hash demo');

        $this->info('redis hash demo 可用于小红点、数据统计等场景');
        $redisHashKey = 'redis:hash:key';

        $this->info('$this->redis->hMSet($redisHashKey, array(\'name\' => \'Joe\', \'salary\' => 2000));
$result = $this->redis->hGetAll($redisHashKey);
$result = $this->redis->hGet($redisHashKey,\'name\');');

        $this->redis->hMSet($redisHashKey, array('name' => 'Joe', 'salary' => 2000));
        $result = $this->redis->hGetAll($redisHashKey);
        dump($result);
        $result = $this->redis->hGet($redisHashKey, 'name');
        dump($result);

        $result = $this->redis->del($redisHashKey);
        if ($result === 1) {
            $this->output->success('redisHashKey 运行完毕清除成功');
        }

        return;
    }

    private function redisListDemo()
    {
        $this->output->title('redis List demo');

        $this->info('redis 队列可用于异步，任务分发，分布式，秒杀等场景');
        $this->info('rPush 配对 lPop ，lPush 配对 rPop,否则视为使用栈');
        $redisListKey = 'redis:list:key';
        for ($i = 1; $i <= 10; $i++) {
            $this->redis->rPush($redisListKey, $i);
        }
        $this->redis->rPush($redisListKey, 'a', 'b', 'c');
        $this->warn('$result = $this->redis->lSize($redisListKey); lsize 已经弃用了');
        // $result = $this->redis->lSize($redisListKey);
        // dump($result);
        while ($this->redis->lLen($redisListKey)) {
            $result = $this->redis->lPop($redisListKey);
            dump($result);
        }
        $result = $this->redis->del($redisListKey);
    }

    private function redisSetDemo()
    {

        $this->output->title('redis set demo');
        $this->info('redDot（小红点场景）');

        $redisSetKey = 'redis:set:key';
        $this->redis->sAdd($redisSetKey, 'v1');                // int(1)
        $this->redis->sAdd($redisSetKey, 'v1', 'v2', 'v3');    // int(2)
        $result = $this->redis->sMembers($redisSetKey);
        dump($result);

        $result = $this->redis->del($redisSetKey);
        if ($result === 1) {
            $this->output->success('redisSetKey 运行完毕清除成功');
        }
    }

    private function redisSortSetDemo()
    {
        $this->output->title('redis set demo');
        $this->info('redDot(小红点场景)');
        $redisSortSetKey = 'redis:sortset:key';

        $this->redis->zAdd('z', 1, 'v1', 2, 'v2', 3, 'v3', 4, 'v4');  // int(2)
        $this->redis->zRem('z', 'v2', 'v3');                           // int(2)
        $this->redis->zAdd('z', ['NX'], 5, 'v5');                      // int(1)
        $this->redis->zAdd('z', ['NX'], 6, 'v5');                      // int(0)


        dump($this->redis->zRange('z', 0, -1));
        // Output:
        // array(4) {
        //   [0]=> string(2) "v1"
        //   [1]=> string(2) "v4"
        //   [2]=> string(2) "v5"
        //   [3]=> string(2) "v8"
        // }

        dump($this->redis->zRange('z', 0, -1, true));
        // Output:
        // array(4) {
        //   ["v1"]=> float(1)
        //   ["v4"]=> float(4)
        //   ["v5"]=> float(5)
        //   ["v6"]=> float(8)
        // }

        $result = $this->redis->del($redisSortSetKey);
        if ($result === 1) {
            $this->output->success('redisSortSetKey 运行完毕清除成功');
        }
    }
}
