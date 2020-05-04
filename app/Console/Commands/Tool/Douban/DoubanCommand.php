<?php

namespace App\Console\Commands\Tool\Douban;

use App\HttpClient\DoubanHttpClient;
use App\Utils\SimpleSystem;
use Illuminate\Console\Command;
use MongoDB\BSON\ObjectId;
use MongoDB\Client as MongoDBClient;

class DoubanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan z:douban:master
     * @var string
     */
    protected $signature = 'z:douban:master';

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
        $this->doAction();
        // $this->del();
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

    public function doAction()
    {
        $doubanConfig = new DoubanConfig(__DIR__ . '/config.json');

        $client = new MongoDBClient();
        $database = $client->selectDatabase('db_simple_laravel');
        $topicContentCollection = $database->selectCollection('douban_topics_content');
        $filter = ['insert_time' => $doubanConfig->getInsertTime()];
        $findResult = $topicContentCollection->find($filter);
        $counter  = 0;
        $this->info('find now');
        foreach ($findResult as $content) {
            $counter += 1;
            $doubanID = env('douban_id');
            if (strpos($content['content'], $doubanID) !== false) {
                $topicUrl = "https://www.douban.com/group/topic/{$content['topic_id']}/?start={$content['page']}";
                if (SimpleSystem::isWin()) {
                    exec("start $topicUrl");
                }
                echo ("https://www.douban.com/group/topic/{$content['topic_id']}/?start={$content['page']}") . PHP_EOL;
            }
        }
        $this->output->success("Finished from {$counter} row");
    }

    public function del()
    {
        return ;
        $client = new MongoDBClient();
        $database = $client->selectDatabase('db_simple_laravel');
        $topicContentCollection = $database->selectCollection('douban_topics');
        $filter = ['insert_time' => '1586781808'];
        $findResult = $topicContentCollection->find($filter);
        $counter  = 0;
        $this->info('find now');
        foreach ($findResult as $content) {
            $counter += 1;
            /**
             * @var \MongoDB\BSON\ObjectId $id
             */
            $id = ($content['_id']);
            // dump((string) ($content['content']));
            $result = $topicContentCollection->findOneAndDelete(['_id' => new ObjectId($id)]);
            dump($result);
            // printf("Deleted %d document(s)\n", $result->getDeletedCount());
        }
    }
}
