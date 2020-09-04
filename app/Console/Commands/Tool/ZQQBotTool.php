<?php

namespace App\Console\Commands\Tool;

use App\Utils\QQUtil;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class ZQQBotTool extends Command
{
    /**
     *  remark 命名规则
     * [前缀[.|·]][姓名]#[tag][:tagInfo][..[tag][:tagInfo]]
     *  前缀: Ztmp2020 | 临时好友
     *         - zt20[-08[-xx]]
     *  前缀: Ztmp2019 | 临时好友
     *  前缀: R | remark is nickname no username
     *  tag: T(eacher) 老师
     *  tag: S(peciality) 专业方向（校园途径）
     *  tag: F(rom) 来源（校外途径）
     *       - sdut
     *  tag: D(ifferent) 区别（区分重名）
     *  tag: I(nfo) 
     *  tag: Z(zzz) 特殊编码
     *  tag: R(remark)  | remark is nickname no username
     */

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:qqtool';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'qq拜年群发';

    /**
     * @var string
     */
    protected $accessToken = 'hzjmytoken';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->init();
    }

    private  $client = null;

    public function init()
    {
        $webHook = 'http://127.0.0.1:6701';

        $this->client = new Client([
            'base_uri' => $webHook,
            'timeout' => 10.0,
            'http_errors' => false,
        ]);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        try {
            $friendList = $this->getFriendList();

            $tmpPath = storage_path('tmp');
            $inputFileName = $tmpPath . '/qqFriendList.json';

            file_put_contents($inputFileName, json_encode($friendList, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

            $num = 0;

            $friendList = QQUtil::usernameEncode($friendList);

            foreach ($friendList as $friend) {

                $messageList = [];
                $userId = $friend['user_id'];
                $name = $friend['aUserInfo']['name'];
                $useRemarkName = $friend['aUserInfo']['R'] ?? false;
                $isTeacher = $friend['aUserInfo']['T'] ?? false;
                $sex = $this->getUserInfo($userId)['data']['sex'] ?? '';

                dump([
                    $userId, $name, $useRemarkName, $isTeacher, $sex
                ]);

                $firstName = str_split($name, 3)[0] ?? $name;
                $newYearName = '老' . $firstName . '同学';
                if ($isTeacher) {
                    $name = $useRemarkName ? $name : $firstName . '老师';
                    $messageList[] = '祝' . $name . '新年快乐，鼠年吉祥, 🐀你健康，🐀你顺利，🐀你快乐';
                } else {
                    switch ($sex) {
                        case 'female':
                            $messageList[] = '祝老' . $firstName . '同学' . '.🐀年健康，🐀年顺利，🐀年快乐，鼠年吉祥';
                            break;
                        case 'male':
                            $t = mt_rand(0, 2);
                            if ($t == 0) {
                                $messageList[] = '老' . $firstName . '新年快乐ha`，';
                            } else if ($t == 1) {
                                $messageList[] = $firstName . '老板新年快乐ha`，';
                            } else {
                                $messageList[] = $firstName . '大大新年快乐ha`，';
                            }
                            $messageList[] = "祝{$newYearName}，新的一年🐀你快乐，🐀你健康，神清气爽，吃嘛嘛香，财源滚滚";
                            break;
                        default:
                            $messageList[] = $name . "同学新年快乐，鼠年大吉" . PHP_EOL . "🐀你快乐，🐀你健康，红包多抢，记得分我";
                            break;
                    }
                }
                $messageList[] = '🐀😁😁😁😁😁😁😁😁😁😁😁😁😁';
                $messageList[] = '🍬🍬🍬';
                $messageList[] = '🐀🤞🐀';

                foreach ($messageList as $message) {
                    dump($message);
                    $result = $this->sender($userId, $message);
                }
                $num += 1;
            }
        } catch (\Exception $e) {
            dump($e->getMessage());
        }
        return;
    }

    /**
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getFriendList()
    {
        $query = [];
        if ($this->accessToken) {
            $query['access_token'] = $this->accessToken;
        }
        $response = $this->client->request('get', '/get_friend_list', [
            'query' => $query
        ]);

        $data = json_decode($response->getBody(), true);

        return array_map(function ($item) {
            return [
                'nickname' => $item['nickname'] ?? '',
                'remark' => $item['remark'] ?? '',
                'user_id' => $item['user_id'] ?? ''

            ];
        }, $data['data'] ?? []);
    }

    /**
     * @info 发送消息
     * @param $userId
     * @param $message
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sender($userId, $message): string
    {
        return 'ceshi';

        $query = [
            'access_token' => $this->accessToken,
            'message' => $message,
            'user_id' => $userId,
        ];

        $response = $this->client->request('get', '/send_private_msg_rate_limited', [
            'query' => $query
        ]);


        return $response->getBody();
    }


    /**
     * @info 获取用户信息
     * @param $userId
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserInfo($userId): array
    {
        $response = $this->client->request('get', '/get_stranger_info', [
            'query' => [
                'access_token' => $this->accessToken,
                'user_id' => $userId,
                'no_cache' => false,
            ]
        ]);
        return json_decode($response->getBody(), true);
    }
}
