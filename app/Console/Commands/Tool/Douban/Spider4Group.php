<?php

namespace App\Console\Commands\Tool\Douban;

use App\Exceptions\DouBanException;
use App\Models\DouBanTopic;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\DomCrawler\Crawler;

class SuperS1GroupSpider extends Command
{
    use UtilTrait;

    /**
     * php artisan z:douban:group
     *
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:sdouban:group';

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
        $this->init(__DIR__ . '/config.json');

        $groupList = [];
        $useGroupList = false;
        if ($useGroupList) {
            $groupList = array_map(function ($value) {
                return $value['id'];
            }, $this->doubanConfig->getGroupList());
        } else {
            $groupList[] = $this->doubanConfig->getGroupId();
        }

        foreach ($groupList as $groupId) {
            $this->runner($groupId, $this->doubanConfig);
        }
        return;
    }

    protected function runner($groupId, DouBanConfig $config)
    {
        $this->info("当前groupId" . $groupId);
        $doubanPath = storage_path('tmp' . DIRECTORY_SEPARATOR . 'douban');
        $doubanGroupPath = $doubanPath . DIRECTORY_SEPARATOR . 'group';
        $groupIdPath = $doubanGroupPath . DIRECTORY_SEPARATOR . $groupId;

        is_dir($doubanPath) || mkdir($doubanPath, 0777, true);
        is_dir($doubanGroupPath) || mkdir($doubanGroupPath, 0777, true);
        is_dir($groupIdPath) || mkdir($groupIdPath, 0777, true);

        try {
            $this->s($groupIdPath, $groupId, $config);
        } catch (Exception $e) {
            if ($e->getCode() === self::CONTINUE_S) {
                $this->warn($e->getMessage());
            } else {
                throw $e;
            }
        }

        $this->output->success("groupId {$groupId} success");
    }

    const KEY_PAGE_N  = "key:page:n";
    /**
     * @param $groupIdPath
     * @param $groupId
     * @param DouBanConfig $config
     * @throws Exception
     */
    public function s($groupIdPath, $groupId, DouBanConfig $config)
    {
        $counter = 0;
        $n = $config->getStart();

        if (!is_null(Cache::get(self::KEY_PAGE_N))) {
            $n = Cache::get(self::KEY_PAGE_N);
        }

        $insertTime = $config->getInsertTime();
        $endNumber = $config->getEnd();
        $retry = 0;

        while ($n < $endNumber) {
            try {
                $cacheKey = "group:{$groupId}|n:{$n}|4";
                $counter += 1;
                $this->info("start:{$n}/{$endNumber},groupId:{$groupId},useTime:" . (microtime(true) - LARAVEL_START));

                if ($isDown = $this->redis->get($cacheKey)) {
                    $content = file_get_contents($groupIdPath . DIRECTORY_SEPARATOR . $n . '.html');
                    $this->checkDouBanContent($content);
                    $this->info("已抓取->$isDown 不进行操作");
                } else {
                    $this->info($this->getGroupUrl($groupId,$n));
                    $content = $this->doubanClient->getTopicListByGroupId($groupId, $n);
                    $this->checkDouBanContent($content);
                    $this->downFile($groupIdPath . DIRECTORY_SEPARATOR . $n . '.html', $content);
                    $this->inputDB($content, $groupId, $insertTime, $n);
                    $this->info("success:{$n}/{$endNumber},groupId:{$groupId},useTime:" . (microtime(true) - LARAVEL_START));
                }
                Cache::put(self::KEY_PAGE_N, $n, 3600 * 3);
                $retry = 0;
                $n += 25;
                sleep(2);

            } catch (DouBanException $e) {
                throw $e;
            } catch (\Exception $e) {
                $retry += 1;
                if ($retry >= 3) {
                    throw $e;
                }
            }
        }
    }

    public function downFile($path, $content)
    {
        file_put_contents($path, $content);
    }

    public function inputDB($html, $groupId, $insertTime, $n)
    {
        $crawler = new Crawler($html);

        self::$insertDataTmpArr = [];
        $crawler->filter('table[class="olt"]')
            ->filter('tr')
            ->reduce(function (Crawler $crawler, $i) {
                if ($i < 1) {
                    return false;
                }
                return true;
            })
            ->each(function (Crawler $node, $tdI) {
                return $node
                    ->filter('td')
                    ->each(function (Crawler $node, $i) use ($tdI) {
                        $result = '';
                        switch ($i) {
                            case 0:
                                $topicTitle = $node->text();
                                self::$insertDataTmpArr[$tdI]['topicTitle'] = $topicTitle;
                                $topicUrl = $node->filter('a')->attr('href');
                                $result = (explode('/', $topicUrl))[5];
                                self::$insertDataTmpArr[$tdI]['topicId'] = $result;
                                break;
                            case 1:
                                $peopleUrl = $node->filter('a')->attr('href');
                                $peopleNickname = $node->text();
                                self::$insertDataTmpArr[$tdI]['nickname'] = $peopleNickname;
                                $result = (explode('/', $peopleUrl))[4];
                                self::$insertDataTmpArr[$tdI]['userId'] = $result;
                                break;
                            case 2:
                                $replyNum = $node->text();
                                $result = $replyNum;
                                break;
                            case 3:
                                $lastUpdateDate = $node->text();
                                $this->info("最后更新时间" . $lastUpdateDate);
                                $result = $lastUpdateDate;
                                break;
                            default:
                                break;
                        }
                        return $result;
                    });
            });

        foreach (self::$insertDataTmpArr as $item) {
            DouBanTopic::updateOrCreate([
                'topic_id' => $item['topicId']
            ], [
                'topic_id' => $item['topicId'],
                'user_id' => $item['userId'],
                'group_id' => $groupId,
                'topic_title' => $item['topicTitle'],
                'topic_content' => ''
            ]);
        }

    }

    protected static array $insertDataTmpArr = [];

    const CONTINUE_S = 10009;
}


// 197 jp
