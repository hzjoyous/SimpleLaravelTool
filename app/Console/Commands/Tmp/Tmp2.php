<?php

namespace App\Console\Commands\Tmp;

use App\Models\Dog;
use App\Models\DouBanComment;
use App\Models\DouBanTopic;
use App\RemoteClient\HttpClientDouBan;
use App\Service\SystemManager;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

class Tmp2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zz:t2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '临时命令2';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }



    public function t(...$data)
    {
        dump($data);
        $a = true || $a = false;
        dump($a);
        $arr = array_unique([]);
        dump($arr);
    }

    public function t2()
    {
        $faker = Factory::create();
        dump($faker->userAgent,
            $faker->chrome,
            $faker->firefox,
            $faker->safari,
            $faker->opera,
            $faker->internetExplorer,
            '#',
            $faker->userAgent);

    }

    public function t3()
    {
        $result = DB::insert("INSERT INTO dogs ( name, desc, created_at, updated_at) VALUES ( 'name', 'desc', '2020-09-17 20:50:58', '2020-09-17 20:50:58')");
        dump(DB::select("select count(id) from dogs"));
        $dogs = Dog::all();
        foreach ($dogs as $dog) {
            $dog->forceDelete();
        }
        return;
    }

    public function t4()
    {
        $result = DB::select('select topic_id as topicId ,user_id as userId from dou_ban_topics where created_at > "2020-09-18"');
        dd($result);
    }

    /**
     * topic 保存
     */
    public function t5()
    {
        $topic_id = 193195383;
        $doubanClient = new HttpClientDouBan();
        $content = $doubanClient->getTopicByTopicId($topic_id);
        $crawler = new Crawler($content);
        $topicContent = $crawler->filter('div[class="topic-content"]')->text();
        $topic = tap(DouBanTopic::where('topic_id', $topic_id)->first(), function (DouBanTopic $topic) use ($topicContent) {
            $topic->topic_content = $topicContent;
            $topic->save();
            return $topic;
        });
        dump($topic);
    }

    /**
     * ip代理池
     */
    public function t6()
    {
        $arr = json_decode('[{"id":27,"ip":"116.196.85.150","port":3128,"schema":"HTTP","last_check_time":"2020-09-19T11:06:07+08:00"},{"id":409,"ip":"221.182.31.54","port":8080,"schema":"HTTP","last_check_time":"2020-09-19T11:06:08+08:00"},{"id":4286,"ip":"210.26.49.89","port":3128,"schema":"HTTP","last_check_time":"2020-09-19T11:06:08+08:00"},{"id":10972,"ip":"140.207.229.171","port":80,"schema":"HTTP","last_check_time":"2020-09-19T11:06:07+08:00"},{"id":11162,"ip":"47.107.108.83","port":3128,"schema":"HTTP","last_check_time":"2020-09-19T11:06:08+08:00"},{"id":11168,"ip":"104.129.206.209","port":8800,"schema":"HTTP","last_check_time":"2020-09-19T11:06:09+08:00"},{"id":11171,"ip":"116.17.102.139","port":3128,"schema":"HTTP","last_check_time":"2020-09-19T11:06:07+08:00"},{"id":11189,"ip":"104.129.206.163","port":8800,"schema":"HTTP","last_check_time":"2020-09-19T11:06:08+08:00"},{"id":11190,"ip":"104.129.206.165","port":8800,"schema":"HTTP","last_check_time":"2020-09-19T11:06:09+08:00"},{"id":11191,"ip":"104.129.206.167","port":8800,"schema":"HTTP","last_check_time":"2020-09-19T11:06:11+08:00"},{"id":11194,"ip":"104.129.206.177","port":8800,"schema":"HTTP","last_check_time":"2020-09-19T11:06:12+08:00"}]', 1);
        $proxygetallkey = 'http://81.68.131.249:9001/proxy/getall';

        if (!Cache::has($proxygetallkey)) {
            $lastIndex = 0;
            Cache::put($proxygetallkey, $lastIndex);
        } else {
            $lastIndex = Cache::get($proxygetallkey) + 1;
            Cache::put($proxygetallkey, $lastIndex);
        }

        if (!Cache::has($proxygetallkey)) {
            $lastIndex = 0;
            Cache::put($proxygetallkey, $lastIndex);
        } else {
            $lastIndex = Cache::get($proxygetallkey) + 1;
            Cache::put($proxygetallkey, $lastIndex);
        }

        if (!Cache::has($proxygetallkey)) {
            $lastIndex = 0;
            Cache::put($proxygetallkey, $lastIndex);
        } else {
            $lastIndex = Cache::get($proxygetallkey) + 1;
            Cache::put($proxygetallkey, $lastIndex);
        }

        if (!Cache::has($proxygetallkey)) {
            $lastIndex = 0;
            Cache::put($proxygetallkey, $lastIndex);
        } else {
            $lastIndex = Cache::get($proxygetallkey) + 1;
            Cache::put($proxygetallkey, $lastIndex);
        }
        $url = $arr[$lastIndex];
        $proxy = $url["ip"] . ":" . $url["port"];
        Cache::pull($proxygetallkey);
        dump($proxy, $lastIndex);
        return;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {


        $userId = config('simple.douban.s.userId');
//        $userId = '195833834';
        $this->line($userId);
        $topics = DouBanTopic::where('user_id', $userId)->get();
        $comments = DouBanComment::where('user_id', $userId)->get();

        $urlList = [];
        foreach ($topics as $topic) {
            $topicUrl = "https://www.douban.com/group/topic/{$topic->topic_id}/?start=0";
            $urlList[] = [
                $topic->topic_title,
                $topicUrl,
                null
            ];
            if (false && SystemManager::isWin()) {
                exec("start $topicUrl");
            }
        }
        foreach ($comments as $comment) {
            $topicUrl = "https://www.douban.com/group/topic/{$comment->topic_id}/?start=0";
            $urlList[] = [
                mb_substr($comment->comment, 0, 20, 'utf-8'),
                $topicUrl,
                $comment->insert_at,
            ];
            if (false && SystemManager::isWin()) {
                exec("start $topicUrl");
            }
        }


        $this->table(['topic/comment', 'url', 'insertAt'],
            $urlList
        );

        $this->table(['type', 'number'], [
            ['topics', count($topics)],
            ['comments', count($comments)],
            ['count(topics)', DB::select('select count(1) as sum from dou_ban_topics')[0]->sum],
            ['count(comments)', DB::select('select count(1) as sum from dou_ban_comments')[0]->sum],
        ]);

        return;
    }

}
