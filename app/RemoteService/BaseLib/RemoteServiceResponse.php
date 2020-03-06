<?php
/**
 * Created by PhpStorm.
 * User: hzj
 * Date: 2019/4/23
 * Time: 14:21
 */
declare(strict_types=1);

namespace App\RemoteService\BaseLib;

use App\RemoteService\BaseLib\BaseRemoteService;
use App\RemoteService\RemoteServiceConf;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class RemoteServiceResponse
{

    protected $promise;

    protected $content;

    protected $result;

    protected $resultGet = false;

    protected $waitEnd = false;

    protected $conf = null;

    protected $raw2Entity;

    protected $message = [];

    /**
     * RemoteServiceResponse constructor.
     * @param PromiseInterface $promise
     * @param RemoteServiceConf $conf
     * @param callable|null $raw2Entity
     * @param array $message
     */
    public function __construct(PromiseInterface $promise, RemoteServiceConf $conf, callable $raw2Entity = null, $message = [])
    {
        $this->promise    = $promise;
        $this->raw2Entity = $raw2Entity;
        $this->conf       = $conf;
        $this->message    = $message;
    }

    public function getContent(): string
    {
        if ($this->waitEnd === false) {
            try {
                $response      = $this->promise->wait();
                $this->content = (string)($response->getBody());
            } catch (\Throwable $e) {
                \Log::info($e->getMessage());
                $this->content = '';
            }
            /* @var $response Response */
            $this->waitEnd = true;
        }
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        if ($this->resultGet === false) {
            $this->result = $this->conf->isUseResponseFormat() ? $this->conf->getResponseFormat()($this->getContent()) : $this->getContent();
            is_null($this->getRaw2Entity()) || $this->result = $this->getRaw2Entity()($this->result);
            $this->resultGet = true;
        }
        return $this->result;
    }

    /**
     * @return callable|null
     */
    protected function getRaw2Entity(): ?callable
    {
        return $this->raw2Entity;
    }
}
