<?php

namespace App\Console\Commands;

use App\HttpClient\DoubanHttpClient;
use App\HttpClient\TestHttpClient;
use Illuminate\Console\Command;
use MongoDB\BSON\ObjectId;
use MongoDB\Client as MongoDBClient;

class Tmp extends Command
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
    protected $signature = 'z:z';

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
        $this->init();
        $this->delCCData();
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

        $this->testClient = new TestHttpClient();

        $result = $this->testClient->cookieLook();

        dd($result);


        $this->doubanClient = new DoubanHttpClient();

        $this->mongoDBClient = new MongoDBClient();

        $this->mongoDBDatabase = $this->mongoDBClient->selectDatabase('db_simple_laravel');

        return $this;
    }

    public function delCCData()
    {
        $client = new MongoDBClient();
        /**
         * 下述代码等价 $client->test; 详情查看 \MongoDB\Client::__get()
         */
        $database = $client->selectDatabase('db_simple_laravel');

        /**
         * 下述代码等价 $database->users; 详情查看 \MongoDB\Database::__get()
         */
        $topicContentCollection = $database->selectCollection('douban_topics_content');
        $findResult = $topicContentCollection->find(['insert_time' => "1586254811"]);
        $counter  = 0;
        $this->info('find now ');
        foreach ($findResult as $content) {
            // die(("https://www.douban.com/group/topic/{$content['topic_id']}/?start={$content['page']}"));
            $counter += 1;
            // $this->info($content['topic_id']);
            $doubanID = env('douban_id');
            if (strpos($content['content'], $doubanID) !== false) {
                echo ("https://www.douban.com/group/topic/{$content['topic_id']}/?start={$content['page']}") . PHP_EOL;
                // $this->output->success($content['topic_id']);
            }

            // if (strpos($content['content'],  '<!DOCTYPE html>') === false) {
            //     /**
            //      * @var \MongoDB\BSON\ObjectId $id
            //      */
            //     $id = ($content['_id']);
            //     // dump((string) ($content['content']));
            //     $result = $topicContentCollection->findOneAndDelete(['_id' => new ObjectId($id)]);
            //     // dump($result);
            //     // printf("Deleted %d document(s)\n", $result->getDeletedCount());
            // }
        }
        $this->output->success("Finished from {$counter} row");
    }
}
