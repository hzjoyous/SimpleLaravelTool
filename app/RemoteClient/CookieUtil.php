<?php


namespace App\RemoteClient;


use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;

trait CookieUtil
{
    protected ?CookieJar $jar = null;
    protected string $domain = 'localhost';

    protected function getCookieFromDomain(string $domain): CookieJar
    {
        $this->domain = $domain;
        $filePath     = __DIR__ . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . $this->domain;
        if (is_file($filePath)) {
            $cookieStr = file_get_contents($filePath);
        } else {
            $cookieStr = "";
        }
        $cookieArr = SetCookie::fromString($cookieStr)->toArray();
        $this->jar = CookieJar::fromArray(
            $cookieArr,
            $domain
        );
        return $this->jar;
    }

    protected function saveCookie()
    {
        !is_dir(__DIR__ . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR) && mkdir(__DIR__ . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR, 0777, true);
        $filePath  = __DIR__ . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . $this->domain;
        $arr       = $this->jar->toArray();
        $cookieArr = [];
        foreach ($arr as $value) {
            $cookieArr[$value['Name']] = $value['Value'];
        }
        $cookieStr = (string)(new SetCookie($cookieArr));
        file_put_contents($filePath, $cookieStr);
    }

}