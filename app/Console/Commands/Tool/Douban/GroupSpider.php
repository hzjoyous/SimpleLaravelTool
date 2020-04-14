<?php

namespace App\Console\Commands\Tool\Douban;

use App\HttpClient\DoubanHttpClient;;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use MongoDB\Client as MongoDBClient;
use MongoDB\Database;
use Redis;

class GroupSpider extends Command
{
    /**
     * php artisan z:douban:group s
     * 
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:douban:group';

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
        $doubanConfig = new DoubanConfig(__DIR__ . '/config.json');
        $groupId  = $doubanConfig->getGroupId();
        $this->init();

        foreach ($doubanConfig->getGroupList() as $value) {
            $doubanPath = storage_path('tmp' . DIRECTORY_SEPARATOR . 'douban');
            $doubanGroupPath = $doubanPath . DIRECTORY_SEPARATOR . 'group';
            $groupIdPath = $doubanGroupPath . DIRECTORY_SEPARATOR . $groupId;

            is_dir($doubanPath) || mkdir($doubanPath, 0777, true);
            is_dir($doubanGroupPath) || mkdir($doubanGroupPath, 0777, true);
            is_dir($groupIdPath) || mkdir($groupIdPath, 0777, true);

            $groupId = $value['id'];
            $this->info("当前groupId" . $groupId);

            try {
                $this->s($groupIdPath, $groupId, $doubanConfig);
            } catch (\Exception $e) {
                if ($e->getCode() === self::CONTINUE_S) {
                    $this->warn($e->getMessage());
                } else {
                    throw $e;
                }
            }

            $this->output->success("groupId {$groupId} success");
        }
        return;
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

    public function init()
    {
        $this->redis = new Redis();
        $this->redis->connect($this->redisHost, $this->redisPort);
        $this->redis->setOption(Redis::OPT_READ_TIMEOUT, -1);
        $this->redisPassWord && $this->redis->auth($this->redisPassWord);

        $this->doubanClient = new DoubanHttpClient();

        $this->mongoDBClient = new MongoDBClient();

        $this->mongoDBDatabase = $this->mongoDBClient->selectDatabase('db_simple_laravel');

        return $this;
    }

    public function s($groupIdPath, $groupId, DoubanConfig $doubanConfig)
    {
        $counter = 0;
        $n = $doubanConfig->getStart();
        $insertTime = $doubanConfig->getInsertTime();
        $endNumber = $doubanConfig->getEnd();

        while ($n < $endNumber) {
            $cacheKey = "group:{$groupId}|n:{$n}|4";
            $counter += 1;
            $this->info("start:{$n}/{$endNumber},groupId:{$groupId},useTime:" . (microtime(true) - LARAVEL_START));

            if ($isDown = $this->redis->get($cacheKey)) {
                $content = file_get_contents($groupIdPath . DIRECTORY_SEPARATOR . $n . '.html');
                $n += 25;
                $this->info("已抓取->$isDown 不进行操作跳过");
                continue;
            } else {
                $this->info("https://www.douban.com/group/$groupId/discussion");
                $content = $this->doubanClient->getTopicListByGroupId($groupId, $n);
            }

            $this->checkContent($content);
            $this->downFile($groupIdPath . DIRECTORY_SEPARATOR . $n . '.html', $content);
            $this->inputDB($content, $groupId, $insertTime, $n);

            $this->redis->set($cacheKey, true, 3600);
            $n += 25;
            $this->info("success:{$n}/{$endNumber},groupId:{$groupId},useTime:" . (microtime(true) - LARAVEL_START));
        }
    }

    public function checkContent($content)
    {
        if (strpos((string) $content, '<!DOCTYPE html>') === false) {
            throw new \Exception("返回非网页" . $content);
        }
        if (mb_strpos((string) $content, '你访问豆瓣的方式有点像机器人程序', 0, "UTF-8") !== false) {
            throw new \Exception("数据返回异常");
        }
    }

    public function downFile($path, $content)
    {
        file_put_contents($path, $content);
    }

    public function inputDB($html, $groupId, $insertTime, $n)
    {
        $crawler = new Crawler($html);

        $result = $crawler->filter('table[class="olt"]')
            ->filter('tr')
            ->reduce(function (Crawler $crawler, $i) {
                if ($i < 1) {
                    return false;
                }
                return true;
            })
            ->each(function (Crawler $node, $i) {
                $result = $node
                    ->filter('td')
                    ->each(function (Crawler $node, $i) {
                        $result = '';
                        switch ($i) {
                            case 0:
                                $topicUrl =  $node->filter('a')->attr('href');
                                $result = (explode('/', $topicUrl))[5];
                                break;
                            case 1:
                                $peopleUrl = $node->filter('a')->attr('href');
                                $result = (explode('/', $peopleUrl))[4];
                                break;
                            case 2:
                                $replyNum = $node->text();
                                $result = $replyNum;
                                break;
                            case 3:
                                $lastUpdateDate = $node->text();
                                $result = $lastUpdateDate;
                                break;
                            default:
                                break;
                        }
                        return $result;
                    });
                return $result;
            });

        $waitInsert = array_map(function ($item) use ($groupId, $insertTime) {
            return [
                'topic_id' => $item[0],
                'people_id' => $item[1],
                'reply_num' => $item[2],
                'group_id' => $groupId,
                'insert_time' => $insertTime,
            ];
        }, $result);

        if (!$waitInsert) {
            $this->warn('no need insert' . PHP_EOL . "https://www.douban.com/group/$groupId/discussion?start=" . $n);
            throw new \Exception("不存在数据,跳过本组循环.注意检查本次url,https://www.douban.com/group/$groupId/discussion?start=" . $n, self::CONTINUE_S);
        }
        /**
         * @var \MongoDB\Collection  $collection
         */
        $collection = $this->mongoDBDatabase->selectCollection('douban_topics');
        $result = $collection->insertMany(
            $waitInsert
        );
        $this->info("insert count {$result->getInsertedCount()}");
    }

    const CONTINUE_S = 10009;
}
