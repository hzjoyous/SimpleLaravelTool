<?php
/**
 * Created by PhpStorm.
 * User: hzj
 * Date: 2019/4/24
 * Time: 13:33
 */
declare(strict_types=1);

namespace App\RemoteService;

use App\RemoteService\BaseLib\BaseRemoteService;

class RemoteServiceConf
{
    protected $baseUri = '';
    /**
     * @var callable
     */
    protected $responseFormat;

    protected $useResponseFormat = false;

    protected $timeout = 10.0;

    protected $http_errors = false;

    protected $callbackWhenFormatFail = null;

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    /**
     * @param string $baseUri
     * @return RemoteServiceConf
     */
    public function setBaseUri(string $baseUri): RemoteServiceConf
    {
        $this->baseUri = $baseUri;
        return $this;
    }

    /**
     * @return callable
     */
    public function getResponseFormat(): callable
    {
        return $this->responseFormat;
    }

    /**
     * @param callable $responseFormat
     * @return RemoteServiceConf
     */
    public function setResponseFormat(callable $responseFormat): RemoteServiceConf
    {
        $this->setUseResponseFormat(true);
        $this->responseFormat = $responseFormat;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUseResponseFormat(): bool
    {
        return $this->useResponseFormat;
    }

    /**
     * @param bool $useResponseFormat
     * @return RemoteServiceConf
     */
    public function setUseResponseFormat(bool $useResponseFormat): RemoteServiceConf
    {
        $this->useResponseFormat = $useResponseFormat;
        return $this;
    }

    /**
     * @return float
     */
    public function getTimeout(): float
    {
        return $this->timeout;
    }

    /**
     * @param float $timeout
     * @return RemoteServiceConf
     */
    public function setTimeout(float $timeout): RemoteServiceConf
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHttpErrors(): bool
    {
        return $this->http_errors;
    }

    /**
     * @param bool $http_errors
     * @return RemoteServiceConf
     */
    public function setHttpErrors(bool $http_errors): RemoteServiceConf
    {
        $this->http_errors = $http_errors;
        return $this;
    }

    /**
     * @return null
     */
    public function getCallbackWhenFormatFail()
    {
        return $this->callbackWhenFormatFail;
    }

    /**
     * @param null $callbackWhenFormatFail
     * @return RemoteServiceConf
     */
    public function setCallbackWhenFormatFail($callbackWhenFormatFail)
    {
        $this->callbackWhenFormatFail = $callbackWhenFormatFail;
        return $this;
    }

}
