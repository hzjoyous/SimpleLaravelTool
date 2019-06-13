<?php
declare(strict_types=1);

namespace App\RemoteService;


use App\RemoteService\ResponseFormat\VipRemoteServiceResponseFormat;
use App\RemoteService\VipRemoteService\VipRemoteService;

class ZRemoteServiceF
{
    protected $serviceList = [];

    protected $vipRemoteServiceUir = '';

    public function __construct($env = null)
    {
        $c                         = 'xzConfig' . (isset($env) ? '.' . $env : '');
        $config                    = config($c);
        $this->vipRemoteServiceUir = $config['VIP_CLIENT'] ?? '';
    }

    public function getVipRemoteService(): VipRemoteService
    {
        if (isset($this->serviceList[VipRemoteService::class])) {

        } else {
            $conf = (new RemoteServiceConf())
                ->setBaseUri($this->vipRemoteServiceUir)
                ->setResponseFormat((new VipRemoteServiceResponseFormat()));;
            $this->serviceList[VipRemoteService::class] = new VipRemoteService($conf);
        }
        return $this->serviceList[VipRemoteService::class];
    }

}
