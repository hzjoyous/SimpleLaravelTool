<?php


namespace App\RemoteClient;

use Faker\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\RequestOptions;


class H52345Client
{

    protected Client $client;
    protected string $host = "localhost";
    protected CookieJar $jar;

    const COOKIE_FILE_NAME = 'a.h5.2345.cookie.txt';

    public function __construct()
    {
        // 文件读取Cookie
        if (is_file(__DIR__ . DIRECTORY_SEPARATOR . self::COOKIE_FILE_NAME)) {
            $cookieStr = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . self::COOKIE_FILE_NAME);
        } else {
            $cookieStr = "";
        }
        $cookieArr    = SetCookie::fromString($cookieStr)->toArray();
        $this->jar    = CookieJar::fromArray(
            $cookieArr,
            'www.2345.com'
        );
        $this->client = new Client([
            'base_uri'    => 'http://keying-api-dev.2345.com',
            'timeout'     => 10.0,
            'http_errors' => false,
            'verify'      => false,
            'cookies'     => $this->jar,
            //            'proxy' => "127.0.0.1:11000",
            //            'proxy' => $proxy,
            'headers'     => [
                'User-Agent'   => 'User-Agent:Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_8; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50',
                "Connection"   => "keep-alive",
                "Content-Type" => "application/json",
                "NOT"          => 1
            ],
        ]);
    }

    public function __destruct()
    {
        $arr       = $this->jar->toArray();
        $cookieArr = [];
        foreach ($arr as $value) {
            $cookieArr[$value['Name']] = $value['Value'];
        }
        $cookieStr = (string)(new SetCookie($cookieArr));
        file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . self::COOKIE_FILE_NAME, $cookieStr);
    }

    protected function getCommonParams(): array
    {
        $faker = Factory::create();
        return [
            "appVersion"      => "1",
            "os"              => "esse aliquip adipisicing",
            "osSdk"           => "mollit",
            "channel"         => "1",
            "appCode"         => "eu velit",
            "imsi"            => "sunt ullamco cillum",
            "deviceId"        => "tempor Duis",
            "uuid"            => "esse non velit officia",
            "platform"        => "aliqua deserunt",
            "mac"             => "exercitatio",
            "uid"             => "laboris",
            "osv"             => "aliquip",
            "romOsName"       => "non dolor",
            "oem"             => "ea Ut deserunt",
            "registrationId"  => "tempor amet id commodo ut",
            "originalChannel" => "veniam Excepteur consequat",
            "imei"            => "proident mollit anim incididunt",
            "romOsVersion"    => "veniam in est",
            "model"           => "in id D",
            "packageName"     => "cupidatat fugiat magna mollit",
            "brand"           => "in exercitation",
            "timestamp"       => time()
        ];
    }


    public function kPost(string $uri, array $extraParams = [])
    {
        $data     = [
            'extraParams'  => $extraParams,
            'commonParams' => $this->getCommonParams()
        ];
        $response = $this->client->request('POST', $uri, [
            RequestOptions::FORM_PARAMS => [
                'data' => json_encode($data)
            ]
        ]);

        $body = (string)$response->getBody();

        echo ($body) . PHP_EOL;

        return json_decode($body, true);
    }

    public function templateList()
    {
        $extraParams = [
            "pageNo"       => 10,
            "templateType" => 1,
            "channelId"    => 0,
            "isNewUser"    => 1,
            "pageSize"     => 10,
        ];
        return $this->kPost("app/template/list", $extraParams);
    }


    public function channelList()
    {
        return $this->kPost('/app/channel/list', []);
    }

    public function userVideoCheck()
    {

        $extraParams = [
            'videoIds' => [
                "1", "2"
            ]
        ];
        return $this->kPost('/app/userVideo/check', $extraParams);
    }


    public function commonConfig()
    {
        $extraParams = [
        ];
        return $this->kPost('/app/common/config', $extraParams);
    }


    public function demo()
    {

        $extraParams = [
        ];
        return $this->kPost('/app/channel/list', $extraParams);
    }


}