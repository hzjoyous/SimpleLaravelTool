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
            // 'proxy' => "127.0.0.1:11000",
            'headers' => [
                'User-Agent' => 'User-Agent:Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_8; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50',
                // "Accept"           => "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
                // "Accept-Encoding"  => "gzip, deflate, br",
                // "Accept-Language"  => "zh-CN,zh;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6",
                // "Connection"       => "keep-alive",
                // "Host"             => "www.douban.com",
                // "Sec-Fetch-Dest"   => "document",
                // "Sec-Fetch-Mode"   => "navigate",
                // "Sec-Fetch-Site"   => "none",
                // "Sec-Fetch-User"   => "?1",
                // "Upgrade-Insecure-Requests" => "1"
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
