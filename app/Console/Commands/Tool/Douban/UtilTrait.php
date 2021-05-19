<?php


namespace App\Console\Commands\Tool\Douban;


use App\Exceptions\DouBanException;
use App\RemoteClient\HttpClientDouBan;
use Exception;
use Generator;
use MongoDB\Client as MongoDBClient;
use MongoDB\Database;
use \Redis;
use Illuminate\Support\Facades\Redis as FRedis;

trait UtilTrait
{
    private MongoDBClient    $mongoDBClient;
    private Database         $mongoDBDatabase;
    private HttpClientDouBan $doubanClient;
    private Redis            $redis;
    private string           $redisHost     = '127.0.0.1';
    private int              $redisPort     = 6379;
    private string           $redisPassWord = '';
    private string $redisListKey  = 'douban:topic:list';
    private Config $doubanConfig;
    private string $doubanPath;

    protected function getRedis(): Redis
    {
        return $this->redis;
    }

    protected function getMongoDBClient(): MongoDBClient
    {
        return $this->mongoDBClient;
    }

    protected function getDoubanPath(): string
    {
        return $this->doubanPath;
    }

    /**
     * @param string $configFilePath
     * @return $this
     * @throws Exception
     */
    public function init(string $configFilePath = __DIR__ . '/config.json'): static
    {
        $this->doubanConfig = new Config($configFilePath);
        $this->redis = FRedis::connection()->client();

//        $this->redis = new Redis();
//        $this->redis->connect($this->redisHost, $this->redisPort);
//        $this->redis->setOption(Redis::OPT_READ_TIMEOUT, -1);
//        $this->redisPassWord && $this->redis->auth($this->redisPassWord);

        $this->doubanClient = new HttpClientDouBan();

        $this->mongoDBClient = new MongoDBClient();

        $this->mongoDBDatabase = $this->mongoDBClient->selectDatabase('db_simple_laravel');

        $doubanPath = $this->doubanPath = storage_path('tmp' . DIRECTORY_SEPARATOR . 'douban');
        is_dir($doubanPath) || mkdir($doubanPath, 0777, true);

        return $this;
    }

    /**
     * @param string $content
     * @throws DouBanException
     */
    public function checkDouBanContent(string $content)
    {
        //strpos($content, '<!DOCTYPE html>') === false
        if (!str_contains($content, '<!DOCTYPE html>')) {
            throw new DouBanException("返回非网页" . $content);
        }
        if (mb_strpos($content, '你访问豆瓣的方式有点像机器人程序', 0, "UTF-8") !== false) {
            throw new DouBanException("数据返回异常");
        }
    }

    /**
     * @param $start
     * @param $limit
     * @param int $step
     * @return Generator
     * @throws Exception
     */
    protected function xRange($start, $limit, int $step = 1): Generator
    {
        if ($start <= $limit) {
            if ($step <= 0) {
                throw new Exception('Step must be +ve');
            }

            for ($i = $start; $i <= $limit; $i += $step) {
                yield $i;
            }
        } else {
            if ($step >= 0) {
                throw new Exception('Step must be -ve');
            }

            for ($i = $start; $i >= $limit; $i += $step) {
                yield $i;
            }
        }
    }

    protected function getGroupUrl($groupId, $n): string
    {
        return "https://www.douban.com/group/$groupId/discussion?start={$n}";
    }

}
