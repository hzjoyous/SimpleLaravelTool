<?php


namespace App\RemoteClient;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;


class AJK_DKT_fogreLoginClient
{

    use CookieUtil;

    protected Client $client;
    protected string $host       = "localhost";
    protected string $domain     = 'localhost';
    protected string $baseUri    = 'http://localhost:3080';
    protected string $prefixPath = '';

    protected function init()
    {

        $this->baseUri    = 'http://localhost:3080';
        $this->prefixPath = '';

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


    public function kmQueryPost(string $uri, array $query)
    {
        $response = $this->client->request('POST', $this->prefixPath . $uri, [
            RequestOptions::QUERY => $query
        ]);

        $body = (string)$response->getBody();

        echo ($body) . PHP_EOL;

        return json_decode($body, true);
    }

    public function kmQueryGet(string $uri, array $query)
    {
        $query ['access_token'] = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImF1dGhfdG9rZW5fcGFpcl82MGFkZjliMDkyZTRhNi4yNDQ1MDA3NyJ9.eyJpc3MiOiJodHRwczpcL1wvZGFpa2V0b25nLjU4LmNvbSIsImF1ZCI6Imh0dHBzOlwvXC9kYWlrZXRvbmcuNTguY29tIiwianRpIjoiYXV0aF90b2tlbl9wYWlyXzYwYWRmOWIwOTJlNGE2LjI0NDUwMDc3IiwiaWF0IjoxNjIzMzEwMzg0LCJleHAiOjE2MjMzMTAzODQsInVzZXJfaWQiOjU4ODQ3fQ.M0PxGlfKiuCB3djKDbqW-boycLWgzBDBDX8icpjEEKF03x5hmtUx_4MXg0eNxUgtzHwe37pw3-SMEUUGZ3s7KfzzoHdD2aWR4d2FBsSlCmz6L16bjFRhd3PlwyNt-PxEFfLfupxx8itMhueg_n3muUTDpDUxoOv3HzOlMNDd4Mo3sTt8gCPLwXxlOyEp_ZuzO7pB1RZB9AM2tblxiqjmAGW0a61KYQqMN0YIIHYbPnLbM7bhTaqW-2o2nmQQaSox3PDUwk4jrpiM9tIxG9Tx3Wd7mo0TtQaT2DuqMl9xLnkdaQvV4fd2pnuN1N7Y1DvPUtjBi35sY-TIw6NHzpoRrg';

        $response = $this->client->request('GET', $this->prefixPath . $uri, [
            RequestOptions::QUERY => $query
        ]);

        $body = (string)$response->getBody();

        echo ($body) . PHP_EOL;
        return json_decode($body, true);
    }

    public function getUserList()

    {
        return $this->kmQueryGet('api/forge/getUserList', [
        ]);
    }

    public function forgeLoginByUserId()
    {
        return $this->kmQueryPost('api/forge/forgeLoginByUserId', []);
    }
}
