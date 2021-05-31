<?php


namespace App\RemoteClient;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;


class AJKClient
{

    use CookieUtil;
    protected Client $client;
    protected string $host = "localhost";

    public function __construct()
    {

        $base_uri     = 'http://localhost:3080';
        $this->client = new Client([
            'base_uri'    => $base_uri,
            'timeout'     => 10.0,
            'http_errors' => false,
            'verify'      => false,
            'cookies'     => $this->getCookieFromDomain('localhost:3080'),
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


    public function xGet(string $uri, array $params): string
    {
        $response = $this->client->request('POST', $uri, [
            RequestOptions::FORM_PARAMS => $params
        ]);

        $body = (string)$response->getBody();

        echo ($body) . PHP_EOL;

        return $body;
    }

    public function a1(): string
    {
        return $this->xGet('/auth/v1/sso/58-verify', [
        ]);
    }

}
