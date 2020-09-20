<?php

namespace App\Console\Commands\Tool\Douban;

use App\Exceptions\DouBanException;
use App\Models\DouBanComment;
use App\Models\DouBanTopic;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
    {mode=n :运行模式,1(构建队列),2(使用队列)}';
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
     * @throws Exception
     */
    public function handle()
    {
        $mode = $this->argument('mode');

        if ((int)$mode === 3) {
            $this->info("start 发送中制命令");
            if (Cache::put("douban:q:stop", 1)) {
                $this->getOutput()->success("终止命令发送成功");
            } else {
                $this->getOutput()->warning("中制命令发送失败");
            }
            return;
        }

        $this->init();

        switch ($mode) {
            case 9:
                $this->sListBuild();
                break;
            case 2:
                Cache::pull("douban:q:stop");
                if (!Cache::get("douban:q:stop", 0)) {
                    $this->getOutput()->success("中断命令资格开启");
                }
                $this->sListUse();
                break;
            default:
                $this->line("未执行");
                break;
        }
        $this->output->success('success');
        return;
    }

    /**
     * @param bool $intoRight
     * douban topic为groupPage的25倍，且数据较多，起一个队列进行分发爬取，以免爬到地老天荒
     */
    public function sListBuild($intoRight = true)
    {
//        $result = DB::select('select topic_id as topicId ,user_id as userId from dou_ban_topics');
//        $result = DB::select('select topic_id as topicId ,user_id as userId from dou_ban_topics where created_at > "2020-09-18"');
        $userId = config('simple.douban.s.userId');
        $result = DB::select('select topic_id as topicId ,user_id as userId from dou_ban_topics where userId = ?', [$userId]);
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
                if ($intoRight) {
                    call_user_func_array([$this->redis, 'rPush'], $waitPush);
                } else {
                    call_user_func_array([$this->redis, 'lPush'], $waitPush);
                }
                $waitPush = [$this->redisListKey];
                $this->info('input');
            }
        }
        if ($intoRight) {
            call_user_func_array([$this->redis, 'rPush'], $waitPush);
        } else {
            call_user_func_array([$this->redis, 'lPush'], $waitPush);
        }
        $this->output->success("Finished inpout {$counter} ");
    }

    /**
     * @param bool $useRightInputLeftOut
     * @throws DouBanException
     */
    public function sListUse($useRightInputLeftOut = true)
    {
        $count = 0;
        $topicInfoStr = '';
        $retry = 0;
        while ($this->redis->lLen($this->redisListKey)) {
            try {
                $count += 1;
                $this->info("now NO.$count");
                if ($count > 1000) {
                    break;
                }

                if (Cache::get("douban:q:stop", 0)) {
                    $this->line("接收到结束命令，结束任务");
                    break;
                }
                $topicInfoStr = ($useRightInputLeftOut ? $this->redis->lPop($this->redisListKey) : $this->redis->rPop($this->redisListKey));
                if (($lPopSuccess = $topicInfoStr) === false) {
                    $this->line("当前队列为空，任务结束");
                    break;
                }
                $topicInfo = json_decode($topicInfoStr, 1);
                $topicId = $topicInfo['topicId'];
                $userId = $topicInfo['userId'];
                $groupId = $topicInfo['groupId'];
                $this->doAction($topicId, $groupId);
                $retry = 0;
            } catch (DouBanException $e) {
                if ($topicInfoStr) {
                    $result = ($useRightInputLeftOut ? $this->redis->lPush($this->redisListKey, $topicInfoStr) : $this->redis->rPush($this->redisListKey, $topicInfoStr));
                    $this->warn(($useRightInputLeftOut ? "使用的是右进左出" : "使用的是左进右出") . "已撤回 ：push {$topicInfoStr} end ,now list {$result}, and you need restart");
                }
                Mail::raw('easy', function ($message) {
                    $message->subject("异常邮件:ip更换提醒");
                    // 指定发送到哪个邮箱账号
                    $message->to(env('MAIL_USERNAME'));
                });
                throw $e;
            } catch (Exception $e) {
                $retry += 1;
                $this->warn("捕获异常，开始重试：no.$retry ");
                $this->warn($e->getMessage());
                if ($retry >= 3) {
                    $this->warn("已到达最大重试次数：3,程序停止");
                    if ($topicInfoStr) {
                        $result = ($useRightInputLeftOut ? $this->redis->lPush($this->redisListKey, $topicInfoStr) : $this->redis->rPush($this->redisListKey, $topicInfoStr));
                        $this->warn(($useRightInputLeftOut ? "使用的是右进左出" : "使用的是左进右出" ). "已经撤回 ： push {$topicInfoStr} end ,now list {$result}, and you need restart");
                    }
//                    $this->info($e->getTraceAsString());
                    throw $e;
                }
            }
        }
        $this->output->success("Finished");
    }

    /**
     * @param $topicId
     * @param $groupId
     * @throws DouBanException
     * @throws Exception
     */
    protected function doAction($topicId, $groupId)
    {
        sleep(2);
        $content = $this->doubanClient->getTopicByTopicId($topicId);
        $this->checkDouBanContent($content);
        $crawler = new Crawler($content);
        $topicContent = $crawler->filter('div[class="topic-content"]')->text();
        // 更新 topic 的 content
        tap(DouBanTopic::where('topic_id', $topicId)->first(), function (DouBanTopic $topic) use ($topicContent) {
            $topic->topic_content = $topicContent;
            $topic->save();
            return $topic;
        });

        $this->useContent($content, $topicId, $groupId);

        if ($crawler->filter('div[class="paginator"]')->count() !== 0) {
            sleep(2);
            $pageText = $crawler->filter('div[class="paginator"]')->last()->eq(0)->text();
            $page = explode(' ', $pageText);
            $pageNumber = $page[count($page) - 2];
            foreach ($this->xRange(1, $pageNumber) as $nowPageNumber) {
                $content = $this->doubanClient->getTopicByTopicId($topicId, (string)($nowPageNumber * 100));
                $this->useContent($content, $topicId, $groupId, (string)($nowPageNumber * 100));
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
     * @throws Exception
     */
    protected function xRange($start, $limit, $step = 1)
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
}
