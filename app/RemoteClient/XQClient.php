<?php


namespace App\RemoteClient;

use Faker\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\RequestOptions;


class XQClient
{

    use CookieUtil;
    protected Client $client;
    protected string $host = "localhost";

    public function __construct()
    {

        $base_uri     = 'http://h5-dev.2345.cn:3000';
        $this->client = new Client([
            'base_uri'    => $base_uri,
            'timeout'     => 10.0,
            'http_errors' => false,
            'verify'      => false,
            'cookies'     => $this->getCookieFromDomain('h5-dev.2345.cn'),
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