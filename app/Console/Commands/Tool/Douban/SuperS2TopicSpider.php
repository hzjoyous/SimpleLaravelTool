<?php

namespace App\Console\Commands\Tool\Douban;

use App\Models\DouBanComment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

class SuperS2TopicSpider extends Command
{
    use DoubanTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:sdouban:topic
    {mode=n :运行模式,slb(构建队列),slu(使用队列)}';
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
     * @throws \Exception
     */
    public function handle()
    {
        $mode = $this->argument('mode');

        $doubanConfig = new DouBanConfig(__DIR__ . '/config.json');

        $this->init();


        $this->sListUse();
        return;
        switch ($mode) {
            case 'slu':
                $this->sListUse();
                break;
            case 'slb':
                $this->sListBuild();
                break;
            default:
                break;
        }
        $this->output->success('success');
        return;
    }

    /**
     * douban topic为groupPage的25倍，且数据较多，起一个队列进行分发爬取，以免爬到地老天荒
     */
    public function sListBuild()
    {
        $result = DB::select('select topic_id as topicId ,user_id as userId from dou_ban_topics');

        $counter = 0;
        $waitPush = [$this->redisListKey];
        foreach ($result as $topicInfo) {
            $waitPush[] = json_encode([
                'topicId' => $topicInfo->topicId,
                'userId' => $topicInfo->userId,
                'groupId' => '593151',
            ]);
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
        $count = 0;
        try {
            $topicInfoStr = '';
            while ($this->redis->lLen($this->redisListKey)) {
                $count += 1;
                $this->info("now NO.$count");
                if ($count > 10000) {
                    break;
                }
                $topicInfoStr = $this->redis->lPop($this->redisListKey);
                if (($lPopSuccess = $topicInfoStr) === false) {
                    break;
                }
                $topicInfo = json_decode($topicInfoStr, 1);
                $topicId = $topicInfo['topicId'];
                $userId = $topicInfo['userId'];
                $groupId = $topicInfo['groupId'];
                $this->doAction($topicId, $groupId);
            }
        } catch (\Exception $e) {
            if ($topicInfoStr) {
                $result = $this->redis->lPush($this->redisListKey, $topicInfoStr);
                $this->warn("push {$topicInfoStr} end ,now list {$result}, and you need restart");
            }
            $this->info($e->getTraceAsString());
            throw $e;
        }
        $this->output->success("Finished");
    }

    /**
     * @param $topicId
     * @param $groupId
     * @throws \App\Exceptions\DouBanException
     */
    protected function doAction($topicId, $groupId)
    {
//        sleep(2);
        $content = $this->doubanClient->getTopicByTopicId($topicId);
        $this->checkDouBanContent($content);
        $crawler = new Crawler($content);
        $this->useContent($content, $topicId, $groupId);

        if ($crawler->filter('div[class="paginator"]')->count() !== 0) {
//            sleep(2);
            $pageText = $crawler->filter('div[class="paginator"]')->last()->eq(0)->text();
            $page = explode(' ', $pageText);
            $pageNumber = $page[count($page) - 2];
            foreach ($this->xRange(1, $pageNumber) as $nowPageNumber) {
                $content = $this->doubanClient->getTopicByTopicId($topicId, (string)($nowPageNumber * 100));
                $this->useContent($content, $topicId, $groupId, $nowPageNumber);
            }
        }
    }

    protected function useContent($content, $topicId, $groupId = 0, $nowPageNumber = 0)
    {
        $this->info("start www.douban.com/group/topic/$topicId/?start=$nowPageNumber");
        $crawler = new Crawler($content);
        $crawler->filter('ul[class="topic-reply"]')
            ->filter('div[class="reply-doc content"]')
            ->each(function (Crawler $node, $tdI) use ($topicId, $groupId) {
                $commentId = $node->parents()->attr('data-cid');
                $comment = $node->filter('p[class=" reply-content"]')->text();
                $userUrl = $node->filter('h4')->filter('a')->attr('href');
                $userId = (explode('/', $userUrl))[4];
                $insertTime = $node->filter('h4')->filter('span[class="pubtime"]')->text();

                $user_id = $userId;
                $topic_id = $topicId;
                $comment_id = $commentId;
                $insert_at = (new \DateTime($insertTime))->format('Y-m-d H:i:s');
                $result = DouBanComment::updateOrCreate(
                    ['comment_id' => $comment_id],
                    [
                        'user_id' => $user_id,
                        'topic_id' => $topic_id,
                        'comment_id' => $comment_id,
                        'comment' => $comment,
                        'insert_at' => $insert_at,
                    ]);

                return $node->text();

            });
        $this->info("finish www.douban.com/group/topic/$topicId/?start=$nowPageNumber");
        return;
    }

    /**
     * @param $start
     * @param $limit
     * @param int $step
     * @return \Generator
     * @throws \Exception
     */
    protected function xRange($start, $limit, $step = 1)
    {
        if ($start <= $limit) {
            if ($step <= 0) {
                throw new \Exception('Step must be +ve');
            }

            for ($i = $start; $i <= $limit; $i += $step) {
                yield $i;
            }
        } else {
            if ($step >= 0) {
                throw new \Exception('Step must be -ve');
            }

            for ($i = $start; $i >= $limit; $i += $step) {
                yield $i;
            }
        }
    }
}
