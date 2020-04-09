<?php

declare(strict_types=1);

namespace App\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;

class TestHttpClient
{
    /**
     * @var Client $client
     */
    protected $client;

    /**
     * @var CookieJar $jar;
     */
    protected $jar;

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
            '127.0.0.1'
        );
        $this->client = new Client([
            'base_uri' => 'http://127.0.0.1:8000',
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


    public function cookieLook(): string
    {
        $response = $this->client->request('get', "/api/cookie-look", [
            'query' => []
        ]);
        // dump($response);
        return (string) $this->client->request('get', "/api/cookie-look", [
            'query' => []
        ])->getBody();
    }

}
