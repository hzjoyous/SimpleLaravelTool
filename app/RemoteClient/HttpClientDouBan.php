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
    use CookieUtil;
    /**
     * @var Client $client
     */
    protected Client $client;

    protected string $host = "www.douban.com";

    public function __construct()
    {

        $proxy = "127.0.0.1:11000";
        // http header 不区分大小写
        $this->client = new Client([
            'base_uri'    => 'https://www.douban.com',
            'timeout'     => 10.0,
            'http_errors' => false,
            'verify'      => false,
            'cookies'     => $this->getCookieFromDomain($this->host),
            //            'proxy' => "127.0.0.1:11000",
            'proxy'       => $proxy,
            'headers'     => [
                'User-Agent' => 'User-Agent:Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_8; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50',
                "Connection" => "keep-alive",
            ],
        ]);
    }


    public function __destruct()
    {
        $this->saveCookie();
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


}
