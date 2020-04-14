<?php

namespace App\Console\Commands\Tool\Douban;

use App\HttpClient\DoubanHttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Statement;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Finder\Finder;
use MongoDB\Client as MongoDBClient;
use MongoDB\Database;

class ZOldGroupSpider extends Command
{
    /**
     * php artisan z:douban:group s
     * php artisan z:douban:group b
     * php artisan z:douban:group bm
     * 
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'old:douban:group 
    {mode=n :运行模式,s(蜘蛛),b(构建),bm(入库mongodb)}';

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
        $mode = $this->argument('mode');

        $doubanConfig = new DoubanConfig(__DIR__ . '/config.json');
        $groupId  = $doubanConfig->getGroupId();
        $start = $doubanConfig->getStart();
        $end = $doubanConfig->getEnd();
        $insertTime = $doubanConfig->getInsertTime();

        $doubanPath = storage_path('tmp' . DIRECTORY_SEPARATOR . 'douban');
        if (is_dir($doubanPath) || mkdir($doubanPath, 0777, true)) {
        }
        $doubanGroupPath = $doubanPath . DIRECTORY_SEPARATOR . 'group';
        if (is_dir($doubanGroupPath) || mkdir($doubanGroupPath, 0777, true)) {
        }
        $groupIdPath = $doubanGroupPath . DIRECTORY_SEPARATOR . $groupId;
        if (is_dir($groupIdPath) || mkdir($groupIdPath, 0777, true)) {
        }
        $this->init();

        switch ($mode) {
            case 's':
                $this->s($groupIdPath, $groupId, $start, $end);
                break;
            case 'b':
                $this->b($groupIdPath, $doubanGroupPath, $groupId, $insertTime);
                break;
            case 'bm':
                $this->bm($doubanGroupPath, $groupId, $insertTime);
                break;
            default:
                break;
        }
        $this->output->success('success');
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

    public function init()
    {

        $this->doubanClient = new DoubanHttpClient();

        $this->mongoDBClient = new MongoDBClient();

        $this->mongoDBDatabase = $this->mongoDBClient->selectDatabase('db_simple_laravel');

        return $this;
    }

    public function b($groupIdPath, $doubanGroupPath, $groupId, $insertTime)
    {

        $f = new Finder();
        $files = $f->files()->in($groupIdPath)->sortByModifiedTime();
        $i = 0;

        $collection = $this->mongoDBDatabase->selectCollection('douban_topics');
        file_put_contents($doubanGroupPath . DIRECTORY_SEPARATOR . $groupId . '.csv', 'replyNum,topic,people,html' . PHP_EOL);
        /**
         * @var \Symfony\Component\Finder\SplFileInfo $file
         */
        foreach ($files as $file) {
            if ($i % 10 === 0) {
                dump($file->getFilename());
            }
            $i++;
            $resultData = '';
            $realPath = $file->getRealPath();
            $content = $file->getContents();
            $crawler = new Crawler($content);
            $crawler = $crawler->filter('html > body')
                ->filter('tr')
                ->reduce(function (Crawler $crawler, $i) use (&$resultData, $realPath, $insertTime, $groupId, $collection) {
                    if ($i <= 1) {
                        return false;
                    }
                    $num = 0;
                    foreach ($crawler->filter('td') as $domElement) {
                        /**
                         * @var \DOMElement $domElement
                         */
                        $num += 1;
                        if ($num === 3) {
                            $replyNum = ($domElement->textContent);
                        }
                    }
                    $crawler = $crawler->filter('a');
                    if (count($crawler) !== 2) {
                        $this->output->error('节点数量不匹配');
                    }
                    $num = 0;
                    foreach ($crawler as $domElement) {
                        /**
                         * @var \DOMElement $domElement
                         */
                        switch ($num) {
                            case 0:
                                $topicUrl = $domElement->getAttribute('href');
                                break;
                            case 1:
                                $peopleUrl = $domElement->getAttribute('href');
                                break;
                            default:
                                $this->output->error('节点不匹配');
                        }
                        $num += 1;
                    }
                    $resultData .= $replyNum . ',' . $topicUrl . ',' . $peopleUrl . ',' . $realPath . PHP_EOL;
                    $item = [];
                    $item['topic_id'] = (explode('/', $topicUrl))[5];
                    $item['people_id'] = (explode('/', $peopleUrl))[4];
                    $item['reply_num'] = $replyNum;
                    $item['group_id'] = $groupId;
                    $item['insert_time'] = (string) $insertTime;
                    $collection->insertOne(
                        $item
                    );
                    return true;
                });

            file_put_contents($doubanGroupPath . DIRECTORY_SEPARATOR . $groupId . '.csv', $resultData, 8);
        }
    }

    public function s($groupIdPath, $groupId, $n = 0, $endNumber = 511300)
    {
        while ($n < $endNumber) {
            $content = $this->doubanClient->getTopicListByGroupId($groupId, $n);

            if (strpos((string) $content, '<!DOCTYPE html>') === false) {
                $this->error("groupId:{$groupId},n:{$n},endNumber:{$endNumber}");
                break;
            }
            file_put_contents($groupIdPath . DIRECTORY_SEPARATOR . $n . '.html', $content);
            $n += 25;
            $this->info("now:{$n},{$endNumber},useTime:" . (microtime(true) - LARAVEL_START));
        }
    }

    public function bm($doubanGroupPath, $groupId, $insertTime)
    {
        $csvPath  = $doubanGroupPath . DIRECTORY_SEPARATOR . $groupId . '.csv';
        $csv = Reader::createFromPath($csvPath);
        $csv->setHeaderOffset(0);

        $stmt = (new Statement());
        $records = $stmt->process($csv);

        $waitInsertData = [];
        $counter = 0;

        /**
         *  db.douban_topics.createIndex({topic_id:1})
         *  db.douban_topics.createIndex({people_id:1})
         */
        $collection = $this->mongoDBDatabase->selectCollection('douban_topics');
        foreach ($records as $record) {
            $item = [];
            $item['topic_id'] = (explode('/', $record["topic"]))[5];
            $item['people_id'] = (explode('/', $record["people"]))[4];
            $item['reply_num'] = $record["replyNum"];
            $item['group_id'] = $groupId;
            $item['insert_time'] = (string) $insertTime;
            $counter += 1;
            $waitInsertData[] = $item;
            if ($counter > 5000) {
                $collection->insertMany(
                    $waitInsertData
                );
                $waitInsertData = [];
                $counter = 0;
                $this->info('insert 5000');
            }
        }
        $collection->insertMany(
            $waitInsertData
        );
        $waitInsertData = [];
        $counter = 0;
        $this->output->success("Finished insertTime :{$insertTime}");
    }
}
