<?php


namespace App\RemoteClient;

use Faker\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\RequestOptions;


class KClient
{

    use CookieUtil;

    protected Client $client;
    protected string $host = "localhost";

    protected string $domain = 'localhost';
    protected string $baseUri = 'http://localhost';
    protected string $prefixPath = '';

    protected function init()
    {

//        $this->baseUri    = 'http://keying-api-dev.2345.com:3000';
//        $this->prefixPath = '';

        $this->baseUri    = 'http://localhost:3000';
        $this->prefixPath = '/keying-api';

    }

    public function __construct()
    {
        $this->init();
        $this->client = new Client([
            'base_uri'    => $this->baseUri,
            'timeout'     => 10.0,
            'http_errors' => false,
            'verify'      => false,
            'cookies'     => $this->getCookieFromDomain($this->domain),
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
        $this->saveCookie();
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
        $response = $this->client->request('POST', $this->prefixPath . $uri, [
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
