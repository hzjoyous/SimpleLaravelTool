<?php


namespace App\Console\Commands\Tool\Douban;


use App\Exceptions\DouBanException;
use App\RemoteClient\HttpClientDouBan;
use MongoDB\Client as MongoDBClient;
use MongoDB\Database;
use \Redis;

trait DoubanTrait
{
    private MongoDBClient $mongoDBClient;
    private Database $mongoDBDatabase;
    private HttpClientDouBan $doubanClient;
    private Redis $redis;
    private string $redisHost = '127.0.0.1';
    private int $redisPort = 6379;
    private string $redisPassWord = '';
    private string $redisListKey = 'douban:topic:list';
    private DouBanConfig $doubanConfig;
    private string $doubanPath;

    /**
     * @param string $configFilePath
     * @return $this
     * @throws \Exception
     */
    public function init($configFilePath = __DIR__ . '/config.json')
    {
        $this->doubanConfig = new DouBanConfig($configFilePath);

        $this->redis = new Redis();
        $this->redis->connect($this->redisHost, $this->redisPort);
        $this->redis->setOption(Redis::OPT_READ_TIMEOUT, -1);
        $this->redisPassWord && $this->redis->auth($this->redisPassWord);

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
        if (strpos($content, '<!DOCTYPE html>') === false) {
            throw new DouBanException("返回非网页" . $content);
        }
        if (mb_strpos($content, '你访问豆瓣的方式有点像机器人程序', 0, "UTF-8") !== false) {
            throw new DouBanException("数据返回异常");
        }
    }


}