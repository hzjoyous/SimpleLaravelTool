<?php


namespace App\RemoteClient;


use GuzzleHttp\Client;

class HttpClientCQ
{
    /**
     * @var Client $client
     */
    protected $client;

    protected $baseQuery = [
        'access_token' => 'hzjmytoken',
    ];

    protected function buildQuery($query)
    {
        return array_merge($query, $this->baseQuery);
    }

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://127.0.0.1:6701',
            'timeout' => 10.0,
            'http_errors' => false,
        ]);
    }

    public function getUserInfo($userId): string
    {

        $response = $this->client->request('get', '/get_stranger_info', [
            'query' => $this->buildQuery([
                'user_id' => $userId,
                'no_cache' => false,
            ])
        ]);
        return $response->getBody();
    }

    public function sendPrivateMsg($userId, $message): string
    {
        $query = [
            'message' => $message,
            'user_id' => $userId,
        ];

        return $this->client->request('get', '/send_private_msg', [
            'query' => $this->buildQuery($query)
        ])->getBody();
    }

    public function sendGroupMsg($groupId, $message): string
    {
        return $this->client->request('get', '/send_group_msg', [
            'query' => $this->buildQuery([
                'group_id' => $groupId,
                'message' => $message,
                'auto_escape'=>false
            ])
        ])->getBody();
    }

    public function getGroupList():string {
        return $this->client->request('get','/get_group_list',[

        ])->getBody();
    }

    public function atGroupPeople($userId)
    {
        return '[CQ:at,qq='.$userId.']';
    }


}
