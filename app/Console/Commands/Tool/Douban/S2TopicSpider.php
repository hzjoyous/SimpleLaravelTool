<?php

namespace App\Console\Commands\Tool\Douban;

use Illuminate\Console\Command;

class S2TopicSpider extends Command
{
    use DoubanTrait;

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
     * @throws \Exception
     */
    public function handle()
    {
        $mode = $this->argument('mode');

        $doubanConfig = new DouBanConfig(__DIR__ . '/config.json');
        $insertTime = $doubanConfig->getInsertTime();

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
        return;
    }

    /**
     * douban topic为groupPage的25倍，且数据较多，起一个队列进行分发爬取，以免爬到地老天荒
     */
    public function sListBuild($insertTime)
    {
        $mongoDBDatabase = $this->mongoDBDatabase;
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
        $topicContentCollection = $mongoDBDatabase->selectCollection('douban_topics_content');
        try {
            $topicInfoStr = '';
            while ($this->redis->lLen($this->redisListKey)) {
                $topicInfoStr = $this->redis->lPop($this->redisListKey);
                if (($lPopSuccess = $topicInfoStr) === false) {
                    break;
                }
                $topicInfo = json_decode($topicInfoStr, 1);
                $topicId = $topicInfo['topic_id'];
                $replyNum = (int)($topicInfo['reply_num']);
                $groupId = $topicInfo['group_id'];
                $insertTime = $topicInfo['insert_time'];
                $start = 0;
                $pageNum = (int)($replyNum / 100) + 1;
                while ($pageNum--) {
                    $findResult = $topicContentCollection->findOne(['topic_id' => $topicId, 'page' => $start]);
                    // 当前页面可能能为已经更新的最后一夜所以要检测是否有第二页，否则可能忽略部分信息
                    // $findResult = $topicContentCollection->findOne(['topic_id' => $topicId, 'page' => $start + 1]);
                    //false &&
                    if ($findResult !== null) {
                        $this->line("{$topicId}_{$start} 已经存在,跳过");
                    } else {
                        $content = $this->doubanClient->getTopicByTopicId($topicId, $start);
                        $topicContentCollection->insertOne([
                            'topic_id' => $topicId,
                            'page' => $start,
                            'content' => (string)$content,
                            'group_id' => (string)$groupId,
                            'insert_time' => (string)$insertTime
                        ]);
                        if (strpos((string)$content, '<!DOCTYPE html>') === false) {
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
