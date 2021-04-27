<?php


namespace App\RemoteClient;

use Faker\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\RequestOptions;


class XQClient
{

    protected Client $client;
    protected string $host = "localhost";
    protected CookieJar $jar;
    const COOKIE_FILE_NAME = 'a.kmclient.cookie.txt';

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
            'http://h5-dev.2345.cn'
        );
        $base_uri     = 'http://h5-dev.2345.cn:3000';
        $this->client = new Client([
            'base_uri'    => $base_uri,
            'timeout'     => 10.0,
            'http_errors' => false,
            'verify'      => false,
            'cookies'     => $this->jar,
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


    public function xGet(string $uri, array $params)
    {
        $response = $this->client->request('POST', $uri, [
            RequestOptions::FORM_PARAMS => $params
        ]);

        $body = (string)$response->getBody();

        echo ($body) . PHP_EOL;

        return $body;
    }

    public function H5GoPay()
    {
        return $this->xGet('/LyApp/Pay/H5GoPay', [
            'uid'              => '193605',
            'game_name'        => 'bsypt',
            'money'            => '1',
            'partner_order_no' => '1',
            'source'           => '1',
            'I'                => '1',
            'sign'             => '1',
        ]);
    }

}