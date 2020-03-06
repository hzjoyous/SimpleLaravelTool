<?php
declare(strict_types=1);

namespace App\RemoteService;


use App\RemoteService\ResponseFormat\VBotResponseFormat;

class RemoteServiceFactory
{
    private static $serviceList = [];

    /**
     * @return VBotRemoteService
     */
    public static function getVBotRemoteService()
    {
        if (isset(self::$serviceList[__FUNCTION__])) {
            $service = self::$serviceList[__FUNCTION__];
        } else {
            $conf    = (new RemoteServiceConf())
                ->setBaseUri('http://127.0.0.1:8866')
                ->setResponseFormat((new VBotResponseFormat()))
                ;
            ;
            $service = self::$serviceList[__FUNCTION__] = new VBotRemoteService($conf);
        }
        return $service;
    }
}
