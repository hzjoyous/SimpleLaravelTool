<?php


namespace App\Service;


use App\RemoteClient\KClient;
use App\RemoteClient\KMClient;
use App\RemoteClient\XQClient;

class Work
{

    protected KClient $kClient;
    protected KMClient $kmClient;

    public function index()
    {
        dump('启动时间' . (microtime(true) - LARAVEL_START));
//        $this->xq();
        $this->ky();
    }

    public function xq()
    {
        $xqClient = new XQClient();
        $result = $xqClient->H5GoPay();
        dump($result);
    }

    public function ky()
    {

        $this->kClient  = new KClient();
        $this->kmClient = new KMClient();


        dump('commonConfig');
        $result = $this->kClient->commonConfig();
        dump($result);

        $result = $this->kmClient->appConfigList('full_screen_video');
        dd($result);


//        dd();
//        dump('list');
//        $result = $this->kmClient->appConfigSave('template_command');
//        dump($result);
//        $result = $this->kClient->userVideoCheck();
//        dump($result);
//        $result = $this->kClient->templateList();
//        dump($result);
//
//        $result = $this->kmClient->templateSave();
//        $result = json_decode($result,true);
//        dump($result);
//
//        $result = $this->kClient->channelList();
//        dump($result);
//        dump('commonConfig');
//        $result = $this->kClient->commonConfig();
//        dump($result);
//        dd();
//        dump('strictSave');
//        $result = $this->kmClient->strictSave();
//        dump($result);
//
//        dump('getCommonConfig');
//        $result = $this->kmClient->getCommonConfig();
//        dump($result);
//
//        dump('appConfigPublish');
//        $result = $this->kmClient->appConfigPublish();
//        dump($result);


        dump("ADS_CONFIG");
        foreach (
            [
                'open_screen_ads',

                'list_ads',
                'full_screen_video',
                'reward_video',

                'template_recommend',
                'template_recommend_for_new_user'
            ]
            as
            $configType
        ) {

//            dump($configType);
//            dump($configType . 'save');
//            $result = $this->kmClient->appConfigSave($configType);
//            dump($result);

            dump($configType . ':list');
            $result = $this->kmClient->appConfigList($configType);
            dump($result);

//            dump($configType . "Release");
//            $result = $this->kmClient->appConfigRelease($configType);
//            dump($result);
        }
    }
}