<?php

namespace App\Console\Commands\Tool\Douban;

use App\HttpClient\DoubanHttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use Illuminate\Console\Command;
use MongoDB\Client as MongoDBClient;
use MongoDB\Database;
use Redis;

class TopicSpider extends Command
{
    /**
     *  php artisan z:douban:t slb
     *  # ps -ef|grep "douban" | grep -v grep | awk '{print $2}' |  xargs kill -9
     *  php artisan z:douban:top slu >> ~/wsl.log & php artisan z:douban:top slu >> ~/wsl.log & php artisan z:douban:top slu >> ~/wsl.log & php artisan z:douban:top slu >> ~/wsl.log & php artisan z:douban:top slu >> ~/wsl.log & php artisan z:douban:top slu >> ~/wsl.log & php artisan z:douban:top slu >> ~/wsl.log & php artisan z:douban:top slu >> ~/wsl.log &
     *  php artisan z:douban:top slu >> ~/wsl.log & php artisan z:douban:top slu >> ~/wsl.log &
     *  php artisan z:douban:top slu >> ~/wsl.log & php artisan z:douban:top slu >> ~/wsl.log &
     *  php artisan z:douban:top slu >> ~/wsl.log & php artisan z:douban:top slu >> ~/wsl.log &
     */
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:douban:topic
    {mode=n :运行模式,s(蜘蛛),slb(构建队列),slu(使用队列)}';
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
     * @var MongoDBClient mongoDBClient
     */
    private $mongoDBClient;
    /**
     * @var Database $mongoDBDatabase;
     */
    private $mongoDBDatabase;
    /**
     * @var DoubanHttpClient $doubanClient 
     */
    private $doubanClient;

    /**
     * @var Redis $redis
     */
    private $redis;
    private $redisHost = '127.0.0.1';
    private $redisPort = 6379;
    private $redisPassWord = '';
    private $redisListKey = 'douban:topic:list';

    public function init()
    {

        $this->doubanClient = new DoubanHttpClient();
        $this->redis = new Redis();
        $this->redis->connect($this->redisHost, $this->redisPort);
        $this->redis->setOption(Redis::OPT_READ_TIMEOUT, -1);
        $this->redisPassWord && $this->redis->auth($this->redisPassWord);

        $this->mongoDBClient = new MongoDBClient();

        $this->mongoDBDatabase = $this->mongoDBClient->selectDatabase('db_simple_laravel');

        return $this;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $mode = $this->argument('mode');

        $doubanConfig = new DoubanConfig(__DIR__ . '/config.json');
        $insertTime = $doubanConfig->getInsertTime();

        $doubanPath = storage_path('tmp' . DIRECTORY_SEPARATOR . 'douban');
        if (is_dir($doubanPath) || mkdir($doubanPath, 0777, true)) {
        }

        $this->init();
        switch ($mode) {
            case 'slu':
                $this->sListUse();
                break;
            case 'slb':
                $this->sListBuild($insertTime);
                break;
            default:
                break;
        }
        $this->output->success('success');
    }
    /**
     * douban topic为groupPage的25倍，且数据较多，起一个队列进行分发爬取，以免爬到地老天荒
     */
    public function sListBuild($insertTime)
    {
        $mongoDBDatabase = $this->mongoDBDatabase;
        /**
         * @var Database $mongoDBDatabase
         */
        $collection = $mongoDBDatabase->selectCollection('douban_topics');
        $result = $collection->find(['insert_time' => $insertTime]);
        $result = $result->toArray();
        $counter = 0;
        $waitPush = [$this->redisListKey];
        foreach ($result as $topicInfo) {
            $waitPush[] = json_encode($topicInfo);
            $counter += 1;
            if ($counter % 5000 === 0) {
                call_user_func_array([$this->redis, 'rPush'], $waitPush);
                $waitPush = [$this->redisListKey];
                $this->info('input');
            }
        }
        call_user_func_array([$this->redis, 'rPush'], $waitPush);
        $this->output->success("Finished inpout {$counter}");
    }
    /**
     * db.douban_topic_content.update({},{$set:{"group_id":586674}},{multi:true})
     */
    public function sListUse()
    {
        $mongoDBDatabase = $this->mongoDBDatabase;
        /**
         * @var Database $mongoDBDatabase
         */
        $topicContentCollection = $mongoDBDatabase->selectCollection('douban_topics_content');
        try {

            while ($this->redis->lLen($this->redisListKey)) {
                $topicInfoStr = $this->redis->lPop($this->redisListKey);
                $topicInfo = json_decode($topicInfoStr, 1);
                $topicId = $topicInfo['topic_id'];
                $replyNum =  (int) ($topicInfo['reply_num']);
                $groupId = $topicInfo['group_id'];
                $insertTime = $topicInfo['insert_time'];
                $start = 0;
                $pageNum = (int) ($replyNum / 100) + 1;
                while ($pageNum--) {
                    $findResult = $topicContentCollection->findOne(['topic_id' => $topicId, 'page' => $start]);
                    //false &&
                    if ($findResult !== null) {
                        $this->line("{$topicId}_{$start} 已经存在,跳过");
                    } else {
                        $content = $this->doubanClient->getTopicByTopicId($topicId, $start);
                        $topicContentCollection->insertOne([
                            'topic_id' => $topicId,
                            'page' => $start,
                            'content' => (string) $content,
                            'group_id' => (string) $groupId,
                            'insert_time' => (string) $insertTime
                        ]);
                        if (strpos((string) $content, '<!DOCTYPE html>') === false) {
                            $this->error("error content : $content");
                            throw new \Exception('douban', 500);
                        }
                        $this->info("topicId:{$topicId}_{$start},useTime:" . (microtime(true) - LARAVEL_START));
                    }
                    $start += 100;
                }
            }
        } catch (\Exception $e) {
            if ($e->getCode() === 500 && $e->getMessage() === 'douban') {
                $this->redis->lPush($this->redisListKey, $topicInfoStr);
                $this->warn('need change ip');
            } else {
                if ($topicInfoStr) {
                    $this->redis->lPush($this->redisListKey, $topicInfoStr);
                    $this->warn('push success need restart');
                }
                throw $e;
            }
        }
        $this->output->success("Finished");
    }
}
