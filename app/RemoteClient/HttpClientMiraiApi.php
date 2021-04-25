<?php


namespace App\RemoteClient;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class HttpClientMiraiApi
{
    /**
     * @var Client $client
     */
    protected $client;

    /**
     * @var string
     */
    private $sessionKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost:8080',
            'timeout' => 10.0,
            'http_errors' => false,
            'verify' => false,
        ]);
    }


    public function setSessionKey($sessionKey)
    {
        $this->sessionKey = $sessionKey;
    }

    protected function addSessionKey($data = [])
    {
        return array_merge([
            "sessionKey" => $this->sessionKey,
        ], $data);
    }

    public function CheckAndUpdateSessionClint($qq)
    {
        /**
         * 将客户端升级至session绑定客户端
         */
        Cache::pull('HttpClientMiraiApi', null);
        $localSessionDataString = Cache::get('HttpClientMiraiApi', null);
        if ($localSessionDataString === null) {
            dump("new");
            $auth = $this->auth();
            $auth = json_decode($auth, true);
            $sessionKey = $auth['session'];
            $localSessionData = [
                "time" => time(),
                "sessionKey" => $sessionKey
            ];
            $localSessionDataString = json_encode($localSessionData);
            Cache::put('HttpClientMiraiApi', $localSessionDataString, 60*31);
            $releaseResult = $this->verify($sessionKey, $qq);
            dump($releaseResult);
        } else {
            $localSessionData = json_decode($localSessionDataString, true);
            $createTime = $localSessionData['time'];
            if (((time() - $createTime) / 60) > 30) {
                dump("timeOut");
                $auth = $this->auth();
                $auth = json_decode($auth, true);
                $sessionKey = $auth['session'];
                $localSessionData = [
                    "time" => time(),
                    "sessionKey" => $sessionKey
                ];
                $localSessionDataString = json_encode($localSessionData);
                Cache::put('HttpClientMiraiApi', $localSessionDataString, 60 * 31);
                $releaseResult = $this->verify($sessionKey, $qq);
                dump($releaseResult);
            } else {
                dump("old");
                $sessionKey = $localSessionData['sessionKey'];
            }
        }
        $this->setSessionKey($sessionKey);
        return null;
    }

    public function getAbout(): string
    {
        return $this->client->request('get', '/about', [

        ])->getBody();
    }

    public function auth(): string
    {
        $authKey = "INITKEYpHQzpWXk";
        return $this->client->request('post', '/auth', [
            'json' =>
                [
                    'authKey' => $authKey,
                ]

        ])->getBody();
    }


    public function verify($sessionKey, $qq): string
    {
        return $this->client->request('post', '/verify', [
            'json' => [
                "sessionKey" => $sessionKey,
                "qq" => $qq
            ]
        ])->getBody();
    }

    public function release($sessionKey, $qq): string
    {
        return $this->client->request('post', '/release', [
            'json' => [
                "sessionKey" => $sessionKey,
                "qq" => $qq
            ]
        ])->getBody();
    }

    public function sendFriendMessage($qq, $message): string
    {
        dump($this->addSessionKey([
            'target' => $qq,
            "messageChain" => [
                [
                    "type" => "Plain",
                    "text" => $message
                ],
            ]
        ]));
        return $this->client->request('post', '/sendFriendMessage',
            [
                'json' => $this->addSessionKey([
                    'qq' => (int)$qq,
                    "messageChain" => [
                        [
                            "type" => "Plain",
                            "text" => $message
                        ],
                        [
                            "type" => "Plain",
                            "text" => $message
                        ],
                    ]
                ])
            ]
        )->getBody();
    }

}
