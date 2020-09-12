<?php


namespace App\RemoteClient;


use GuzzleHttp\Client;

class HttpClientAip
{
    /**
     * @var Client $client
     */
    protected $client;

    public function __construct()
    {
        $this->client = new Client([

            'base_uri' => 'https://aip.baidubce.com',
            'timeout' => 10.0,
            'http_errors' => false,
            'verify' => false,
        ]);
    }

    public function getAccessToken(): string
    {
        return $this->client->request('post', "/oauth/2.0/token", [
            'query' => [
                'grant_type' => 'client_credentials',
                'client_id' => 'LEVlCI9ymTsByK5PPIis41zV',
                'client_secret' => 'dsEzNQOnpyZ7TK2xxP2ouKaPrjtPFyhQ'
            ]
        ])->getBody();
    }

    public function say($message,$session_id = 'xxxx'):string {
        $accessToken="24.9b509b5640882f31ce29f4152f660768.2592000.1590129949.282335-19549928";
        return $this->client->request('post', '/rpc/2.0/unit/service/chat', [
            'query' => [
                'access_token' => $accessToken
            ],
            'json' =>
                [
                    'log_id' => 'UNITTEST_10000',
                    'version' => '2.0',
                    'service_id' => 'S29166',
                    'session_id' => $session_id,
                    'request' =>
                        [
                            'query' => $message,
                            'user_id' => '88888',
                        ],
                    'dialog_state' =>
                        [
                            'contexts' =>
                                [
                                    'SYS_REMEMBERED_SKILLS' => []
                                ],
                        ],
                ]

        ])->getBody();
    }
}
