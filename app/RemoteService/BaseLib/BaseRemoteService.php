<?php
/**
 * Created by PhpStorm.
 * User: hzj
 * Date: 2019/4/23
 * Time: 13:22
 */
declare(strict_types=1);

namespace App\RemoteService\BaseLib;

use App\RemoteService\RemoteServiceConf;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use function GuzzleHttp\Psr7\build_query;
use Illuminate\Support\Facades\Log;
use Psr\Log\LogLevel;
use XiaoZhu\LodgeUnitBookApp\Service\GlobalService;

class BaseRemoteService
{
    protected $client;

    protected $format;

    protected $conf;

    public function __construct(RemoteServiceConf $conf)
    {
        $this->conf = $conf;
        $config     = [
            'base_uri'    => $this->conf->getBaseUri(),
            'timeout'     => $this->conf->getTimeout(),
            'http_errors' => $this->conf->isHttpErrors(),
        ];
        if (true) {
            $stack      = HandlerStack::create();
            $monolog    = Log::channel();
            $logger     = $monolog;
            $isOpenLog  = true;
            $formatter  = new MessageFormatter('"request":{"uri":"{uri}", "method":"{method}", "body": "{req_body}"}; "response":{"code":{code},"body":{res_body}}');
            $logLevel   = LogLevel::INFO;
            $s          = microtime(true);
            $middleware = function (callable $handler) use ($logger, $formatter, $logLevel, $s, $isOpenLog) {
                return function ($request, array $options) use ($handler, $logger, $formatter, $logLevel, $s, $isOpenLog) {
                    return $handler($request, $options)->then(
                        function ($response) use ($logger, $request, $formatter, $logLevel, $s, $isOpenLog) {
                            if ($isOpenLog) {
                                $message = $formatter->format($request, $response);
//                                $traceId = GlobalService::getTraceId();
//                                $message = $traceId . '[NAME:BUSINESS_NAME_BaseRemoteService] {"BaseRemoteServiceUseTime":' . (microtime(true) - $s) . '} ' . $message;
                                $logger->log($logLevel, $message);
                            }
                            return $response;
                        },
                        function ($reason) use ($logger, $request, $formatter, $isOpenLog) {
                            $response = $reason instanceof RequestException
                                ? $reason->getResponse()
                                : null;
                            $message  = $formatter->format($request, $response, $reason);
//                            $traceId  = GlobalService::getTraceId();
//                            $message  = $traceId . '[NAME:BUSINESS_NAME_BaseRemoteService]' . $message;
                            $logger->notice($message);
                            return \GuzzleHttp\Promise\rejection_for($reason);
                        }
                    );
                };
            };
            $stack->push($middleware);
            $config['handler'] = $stack;
        }
        $this->client = new Client($config);
    }

    protected function get(string $path = '', array $data = [], callable $raw2Entity = null): RemoteServiceResponse
    {
        $promise  = $this->client->getAsync($path, [
            'query' => $data
        ]);
        $response = new RemoteServiceResponse($promise, $this->conf, $raw2Entity, ['uri' => $this->conf->getBaseUri() . $path . '?' . build_query($data)]);
        return $response;
    }

    protected function postBody(string $path = '', string $body = '', callable $raw2Entity = null): RemoteServiceResponse
    {
        $promise  = $this->client->postAsync($path, [
            'body' => $body
        ]);
        $response = new RemoteServiceResponse($promise, $this->conf, $raw2Entity, ['uri' => $this->conf->getBaseUri() . $path, 'body' => $body]);
        return $response;
    }

    protected function postJson(string $path = '', array $data = [], callable $raw2Entity = null): RemoteServiceResponse
    {
        $promise  = $this->client->postAsync($path, [
            'json' => $data
        ]);
        $response = new RemoteServiceResponse($promise, $this->conf, $raw2Entity, ['uri' => $this->conf->getBaseUri() . $path, 'json' => json_encode($data)]);
        return $response;
    }

    protected function postParams(string $path = '', array $data = [], callable $raw2Entity = null): RemoteServiceResponse
    {
        $promise  = $this->client->postAsync($path, [
            'form_params' => $data
        ]);
        $response = new RemoteServiceResponse($promise, $this->conf, $raw2Entity, ['uri' => $this->conf->getBaseUri() . $path . build_query($data)]);
        return $response;
    }

}
