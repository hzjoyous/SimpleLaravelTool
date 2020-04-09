<?php

declare(strict_types=1);

namespace App\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;

class DoubanHttpClient
{
    /**
     * @var Client $client
     */
    protected $client;

    public function __construct()
    {
        // 文件读取Cookie
        if (is_file(__DIR__ . DIRECTORY_SEPARATOR . 'doubanCookie.txt')) {
            $doubanCookieStr = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'doubanCookie.txt');
        } else {
            $doubanCookieStr = "";
        }
        $cookieArr = SetCookie::fromString($doubanCookieStr)->toArray();
        $this->jar = CookieJar::fromArray(
            $cookieArr,
            'www.douban.com'
        );
        $this->client = new Client([
            'base_uri' => 'https://www.douban.com',
            'timeout' => 10.0,
            'http_errors' => false,
            'verify' => false,
            'cookies' => $this->jar,
            'proxy' => "127.0.0.1:11000",
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.162 Safari/537.36 Edg/80.0.361.109'
            ],
        ]);
    }


    public function getTopicByTopicId($topicId, $start = 0): string
    {

        return (string) $this->client->request('get', "/group/topic/$topicId/", [
            'query' => [
                'start' => $start,
            ]
        ])->getBody();
    }

    public function getTopicListByGroupId($groupId = 586674, $start = 0): string
    {
        return (string) $this->client->request('get', "/group/$groupId/discussion", [
            'query' => [
                'start' => $start
            ]
        ])->getBody();
    }

    
    public function __destruct()
    {
        $arr = $this->jar->toArray();
        $cookieArr = [];
        foreach ($arr as $value) {
            $cookieArr[$value['Name']] = $value['Value'];
        }

        $doubanCookieStr = (string) (new SetCookie($cookieArr));
        file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . 'doubanCookie.txt', $doubanCookieStr);
    }
}
