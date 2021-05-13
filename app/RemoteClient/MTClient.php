<?php


namespace App\RemoteClient;

use Faker\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\RequestOptions;


class MTClient
{

    use CookieUtil;
    protected Client $client;
    protected string $host = "localhost";

    public function __construct()
    {
        $base_uri     = 'http://localhost:8080';
        $this->client = new Client([
            'base_uri'    => $base_uri,
            'timeout'     => 10.0,
            'http_errors' => false,
            'verify'      => false,
            'cookies'     => $this->getCookieFromDomain('localhost'),
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

    protected function pJson(string $uri, array $json): string
    {
        $response = $this->client->request('POST', $uri, [
            RequestOptions::JSON => $json
        ]);

        $body = (string)$response->getBody();

        echo ($body) . PHP_EOL;

        return $body;
    }

    public function reg(): string
    {
        $faker = Factory::create();
        return $this->pJson("api/reg", [
            "email"    => microtime(true).$faker->email,
            "userName" => $faker->userName,
            "passWord" => '123456',//$faker->password,
            "nickName" => $faker->name,
        ]);
    }

    public function login():string
    {
        return $this->pJson("api/login", [
            "userName" => 'dicki.andres',
            "passWord" => '123456',
        ]);
    }

    public function aApiNeedJwt($token):string
    {
        $response = $this->client->request('POST', "api/AApiNeedJwt", [
            RequestOptions::JSON => [

            ],
            RequestOptions::HEADERS=>[
                "x-token"=>$token,
            ]
        ]);

        $body = (string)$response->getBody();

        echo ($body) . PHP_EOL;

        return $body;
    }

}