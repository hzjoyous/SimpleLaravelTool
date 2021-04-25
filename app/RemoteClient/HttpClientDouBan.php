<?php

declare(strict_types=1);

namespace App\RemoteClient;

use Faker\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use Illuminate\Support\Facades\Cache;

class HttpClientDouBan
{
    /**
     * @var Client $client
     */
    protected Client $client;

    protected string $host = "www.douban.com";
    protected CookieJar $jar;

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

        $proxy = "127.0.0.1:11000";
        // http header 不区分大小写
        $this->client = new Client([
            'base_uri' => 'https://www.douban.com',
            'timeout' => 10.0,
            'http_errors' => false,
            'verify' => false,
            'cookies' => $this->jar,
//            'proxy' => "127.0.0.1:11000",
            'proxy' => $proxy,
            'headers' => [
                'User-Agent' => 'User-Agent:Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_8; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50',
                "Connection" => "keep-alive",
            ],
        ]);
    }


    public function getTopicByTopicId($topicId, $start = 0): string
    {
        return (string)$this->client->request('get', "/group/topic/$topicId/", [
            'query' => [
                'start' => $start,
            ],
        ])->getBody();
    }


    public function getTopicListByGroupId($groupId = 586674, $start = 0): string
    {
        return (string)$this->client->request('get', "/group/$groupId/discussion", [
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
        $doubanCookieStr = (string)(new SetCookie($cookieArr));
        file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . 'doubanCookie.txt', $doubanCookieStr);
    }
}
