<?php

namespace App\Console\Commands\Tool\QQBot;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ZQQbot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:qqbot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'qqbot';

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
     * @return |null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        dump('2020已使用完毕');
        return ;
        try {

            $webHook = 'http://127.0.0.1:6701';

            $client = new Client([
                'base_uri' => $webHook,
                'timeout' => 10.0,
                'http_errors' => false,
            ]);
            $response = $client->request('get', '/get_friend_list', [
                'query' => [
                    'access_token' => 'hzjmytoken',
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            $friendList = array_map(function ($item) {
                return [
                    'nickname' => $item['nickname'] ?? '',
                    'remark' => $item['remark'] ?? '',
                    'user_id' => $item['user_id'] ?? ''

                ];
            }, $data['data'] ?? []);

            foreach($friendList as $item){

                echo $item['user_id'].PHP_EOL;
            }

            $num = 0;
            foreach ($friendList as $friend) {
                $nickname = $friend['nickname'];
                $remark = $friend['remark'];
                $user_id = $friend['user_id'];
                $name = str_replace(['信科', '一·', '一中', '软件', '能动', '统计', ' ', '美术', '是长得像RE的RE', '20－', '~继国', '1502', '自动', '～'], '', $remark);
                if (in_array($user_id, ['563724681', '176104400', '289883273', '1750686113', '1870786623'])) {
                    dump('## 跳过 ：' . $name);
                    continue;
                }


                $userInfo = ($this->getUserInfo($user_id));

                $userInfo = json_decode($userInfo, true);


                $sex = $userInfo['data']['sex'] ?? '';

                if (strlen($name) % 3 !== 0) {
                    dump('## 跳过（格式问题） :' . $name);
                    continue;
                }

                $result = $this->senderMessage($user_id, $name, $sex);


                if ($user_id == '31792690') {
                    echo 1;
//                        $result = $this->senderMessage($user_id, $name, $sex);

                }
                $num += 1;
                dump("############## $num  ################");
            }
        } catch (\Exception $e) {
            dump($e->getMessage());
        }
        return null;

    }


    /**
     * @param $userId
     * @param $message
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sender($userId, $message): string
    {
        $webHook = 'http://127.0.0.1:6701';

        $client = new Client([
            'base_uri' => $webHook,
            'timeout' => 10.0,
            'http_errors' => false,
        ]);
        $query = [
            'access_token' => 'hzjmytoken',
            'message' => $message,
            'user_id' => $userId,
        ];

//        $response = $client->request('get', '/send_private_msg_rate_limited', [
//            'query' => $query
//        ]);
        dump($query);

        return '##heihei';
    }

    /**
     * @param $userId
     * @param $name
     * @param $sex
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function senderMessage($userId, $name, $sex): string
    {
        $flag = true;
        $message = "";

        $firstName = str_split($name, 3)[0] ?? $name;
        $firstName = str_replace('rrr', '闫', $firstName);
        $newYearName = '老' . $firstName . '同学';
        if (strpos($name, '老师') !== false) {
            $message .= $name . '新年快乐，鼠年吉祥, 🐀你健康，🐀你顺利，🐀你快乐';
        } else {
            switch ($sex) {
                case 'female':
                    $message .= '祝老' . $firstName . '同学' . '.🐀年健康，🐀年顺利，🐀年快乐，鼠年吉祥';
                    break;
                case 'male':
                    $t = mt_rand(0, 2);
                    if ($t == 0) {
                        $message .= '老' . $firstName . '新年快乐ha`，';
                    } else if ($t == 1) {
                        $message .= $firstName . '老板新年快乐ha`，';
                    } else {
                        $message .= $firstName . '大大新年快乐ha`，';
                    }
                    $message .= "祝{$newYearName}，新的一年🐀你快乐，🐀你健康，神清气爽，吃嘛嘛香，财源滚滚";
                    break;
                default:
                    $message .= $name . "同学新年快乐，鼠年大吉" . PHP_EOL;
                    $message .= "🐀你快乐，🐀你健康，红包多抢，记得分我";
                    break;
            }
        }

        dump('## 执行：' . $firstName. '**** | message:' . $message);
        if ($flag) {
            $result = $this->sender($userId, '🐀😁😁😁😁😁😁😁😁😁😁😁😁😁');
            dump('## run1');
            $result = $this->sender($userId, $message);
            dump('## run2');
            if (strpos($name, '老师') !== false) {
                switch ($sex) {
                    case 'female':
                        if (mt_rand(0, 1)) {
                            $result = $this->sender($userId, '🍬🍬🍬');
                        } else {
                            $result = $this->sender($userId, '🍭🍭🍭🍭🍭🍭');
                        }
                        break;
                    default:
                        $result = $this->sender($userId, '🐀🤞🐀');
                        break;
                }
            } else {
                $result = $this->sender($userId, '🐀🤞🐀');
            }
            dump('## run3');
        } else {
            $result = '未发送';
            dump('## 未发送');
        }


        return $result;
    }

    /**
     * @param $userId
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserInfo($userId): string
    {
        $webHook = 'http://127.0.0.1:6701';

        $client = new Client([
            'base_uri' => $webHook,
            'timeout' => 10.0,
            'http_errors' => false,
        ]);
        $response = $client->request('get', '/get_stranger_info', [
//            'from_params' => [
//                'bookOrderId' => 'qwe',
//                'remark'      => '',
//            ],
//            'headers' => [
//                'Content-type' => 'application/json',
//            ],
            'query' => [
                'access_token' => 'hzjmytoken',
                'user_id' => $userId,
                'no_cache' => false,
            ]
        ]);
        return $response->getBody();
    }
}
