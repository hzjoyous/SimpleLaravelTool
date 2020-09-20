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

//        $arr = json_decode('[{"id":27,"ip":"116.196.85.150","port":3128,"schema":"HTTP","last_check_time":"2020-09-19T11:06:07+08:00"},{"id":409,"ip":"221.182.31.54","port":8080,"schema":"HTTP","last_check_time":"2020-09-19T11:06:08+08:00"},{"id":4286,"ip":"210.26.49.89","port":3128,"schema":"HTTP","last_check_time":"2020-09-19T11:06:08+08:00"},{"id":10972,"ip":"140.207.229.171","port":80,"schema":"HTTP","last_check_time":"2020-09-19T11:06:07+08:00"},{"id":11162,"ip":"47.107.108.83","port":3128,"schema":"HTTP","last_check_time":"2020-09-19T11:06:08+08:00"},{"id":11168,"ip":"104.129.206.209","port":8800,"schema":"HTTP","last_check_time":"2020-09-19T11:06:09+08:00"},{"id":11171,"ip":"116.17.102.139","port":3128,"schema":"HTTP","last_check_time":"2020-09-19T11:06:07+08:00"},{"id":11189,"ip":"104.129.206.163","port":8800,"schema":"HTTP","last_check_time":"2020-09-19T11:06:08+08:00"},{"id":11190,"ip":"104.129.206.165","port":8800,"schema":"HTTP","last_check_time":"2020-09-19T11:06:09+08:00"},{"id":11191,"ip":"104.129.206.167","port":8800,"schema":"HTTP","last_check_time":"2020-09-19T11:06:11+08:00"},{"id":11194,"ip":"104.129.206.177","port":8800,"schema":"HTTP","last_check_time":"2020-09-19T11:06:12+08:00"}]', true);
//        $proxygetallkey = 'http://81.68.131.249:9001/proxy/getall';
//
//        if (!Cache::has($proxygetallkey)) {
//            $lastIndex = 0;
//            Cache::put($proxygetallkey, $lastIndex);
//        } else {
//            $lastIndex = Cache::get($proxygetallkey) + 1;
//            Cache::put($proxygetallkey, $lastIndex);
//        }
//        $url = $arr[$lastIndex];
//        $proxy = $url["ip"] . ":" . $url["port"];

//        dump("i use ", $proxy);
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
//            'allow_redirects' => [
//                'max' => 10
//            ],

        ])->getBody();
    }


    public function getTopicListByGroupId($groupId = 586674, $start = 0): string
    {
//        $faker = Factory::create();
        return (string)$this->client->request('get', "/group/$groupId/discussion", [
            'query' => [
                'start' => $start
            ],
//            'headers' => [
//                'User-Agent' => $faker->userAgent
//            ],
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
