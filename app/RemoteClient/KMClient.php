<?php


namespace App\RemoteClient;


use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\RequestOptions;

class KMClient
{

    protected Client $client;

    protected string $host = "localhost";
    protected CookieJar $jar;

    const COOKIE_FILE_NAME = 'a.kmclient.cookie.txt';

    public function __construct()
    {
        $base_uri = 'http://keying-admin-dev.2345.com:3000';
        // 文件读取Cookie
        if (is_file(__DIR__ . DIRECTORY_SEPARATOR . self::COOKIE_FILE_NAME)) {
            $cookieStr = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . self::COOKIE_FILE_NAME);
        } else {
            $cookieStr = "";
        }
        $cookieArr = SetCookie::fromString($cookieStr)->toArray();
        $this->jar = CookieJar::fromArray(
            $cookieArr,
            'www.2345.com'
        );
        $proxy     = "127.0.0.1:11000";
        // http header 不区分大小写
        $this->client = new Client([
            'base_uri'    => $base_uri,
            'timeout'     => 10.0,
            'http_errors' => false,
            'verify'      => false,
            'cookies'     => $this->jar,
            //            'proxy' => "127.0.0.1:11000",
            //            'proxy' => $proxy,
            'headers'     => [
                'User-Agent'   => 'User-Agent:Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_8; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50',
                "Connection"   => "keep-alive",
                "Content-Type" => "application/json",
                "NOT"          => 1,
                "Authtoken"    => "907161AAFDD70557A3FE01929741BEFB"
            ],
        ]);
    }


    public function __destruct()
    {
        $arr       = $this->jar->toArray();
        $cookieArr = [];
        foreach ($arr as $value) {
            $cookieArr[$value['Name']] = $value['Value'];
        }
        $cookieStr = (string)(new SetCookie($cookieArr));
        file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . self::COOKIE_FILE_NAME, $cookieStr);
    }

    public function getCommonParams(): array
    {
        return [
            "appVersion"      => "1",
            "os"              => "esse aliquip adipisicing",
            "osSdk"           => "mollit",
            "channel"         => "1",
            "appCode"         => "eu velit",
            "imsi"            => "sunt ullamco cillum",
            "deviceId"        => "tempor Duis",
            "uuid"            => "esse non velit officia",
            "platform"        => "aliqua deserunt",
            "mac"             => "exercitatio",
            "uid"             => "laboris",
            "osv"             => "aliquip",
            "romOsName"       => "non dolor",
            "oem"             => "ea Ut deserunt",
            "registrationId"  => "tempor amet id commodo ut",
            "originalChannel" => "veniam Excepteur consequat",
            "imei"            => "proident mollit anim incididunt",
            "romOsVersion"    => "veniam in est",
            "model"           => "in id D",
            "packageName"     => "cupidatat fugiat magna mollit",
            "brand"           => "in exercitation",
            "timestamp"       => "ex enim amet in"
        ];
    }

    public function kmQueryPost(string $uri, array $query)
    {
        $response = $this->client->request('POST', $uri, [
            RequestOptions::QUERY => $query
        ]);

        $body = (string)$response->getBody();

        echo ($body) . PHP_EOL;

        return json_decode($body, true);
    }

    public function kmQueryGet(string $uri, array $query)
    {
        $response = $this->client->request('GET', $uri, [
            RequestOptions::QUERY => $query
        ]);

        $body = (string)$response->getBody();
        return json_decode($body, true);
    }

    public function templateSave()
    {
        return $this->kmQueryPost('/admin/template/save', [
                'videoName'         => 'et',
                'name'              => 'DAXIA',
                'templateType'      => '1',
                'maxCount'          => '1',
                'staticCoverLink'   => 'http://localhost/pig',
                'coverLink'         => 'http://localhost/pig',
                'videoUrl'          => 'http://localhost/pig',
                'videoDuration'     => '10',
                'templateUrl'       => 'http://localhost/pig',
                'instructions'      => 'http://localhost/pig',
                'cornerLabel'       => 'dolor',
                'channelArray[]'    => '',
                'id'                => '',
                'md5Value'          => '111',
                'coverLinkType'     => '1',
                'dynamicCoverLink'  => 'http://localhost/pig',
                'useCount'          => '10',
                'startTime'         => '',
                'endTime'           => '',
                'tabPosition'       => '1',
                'segmentType'       => '1',
                'versionCanalIds[]' => '1',
                'topics'            => '123#456',
                'promotionChannels' => 'aaa,dsa,asda',
                'categoryId'        => '1',
                'labelNames'        => '1,2,3,4',
            ]
        );
    }

    public function versionAll()
    {
        $query = [
            'isAll' => 0,
        ];
        return $this->kmQueryGet('/admin/version/all', $query);
    }

    public function versionList()
    {
        $query = [
            'pageSize' => 10,
            //            'page'         => 0,
            //            'searchStatus' => 0,
            //            'searchName'   => 0,
        ];
        return $this->kmQueryGet('/admin/version/list', $query);
    }

    public function appConfigSave($configType = 'open_screen_ads')
    {
        // open_screen_ads
        $allData = [
            'open_screen_ads'                 => [
                "hotStart"  => [
                    "switch"             => 2,
                    "counts"             => 30,
                    "showInterval"       => 0,
                    "backgroundInterval" => 0,
                ],
                "coldStart" => [
                    "switch"             => 2,
                    "counts"             => 99,
                    "showInterval"       => 0,
                    "backgroundInterval" => 0,
                ],
            ],
            'list_ads'                        => [
                'positions' => [
                    0 => 1,
                    1 => 2
                ]
            ],
            'full_screen_video'               => [
                'positions' => [
                    1, 2, 3,
                ]
            ],
            'reward_video'                    => [
                'makeCounts' => [
                    0 => 3,
                    1 => 5,
                    2 => 7,
                    3 => 9,
                    4 => 11
                ]
            ],
            'template_recommend'              => [
                'templateIds' => [
                    1, 2, 3, 4, 5
                ]
            ],
            'template_recommend_for_new_user' => [
                'templateIds' => [
                    1, 2, 3, 4, 5
                ]
            ]
        ];
        // list_ads

        // template_ads

        // template_command

        $query = [
            'id'             => $configType == 'template_command' ? 0 : 0,
            "configType"     => $configType,
            "data"           => $allData[$configType],
            'versionCanalId' => 1,
            'status'         => 1
        ];
        return $this->kmQueryPost('/admin/commonConfig/appConfig/save', $query);
    }

    public function appConfigList($configType = 'open_screen_ads')
    {

        $q = [
            "configType" => $configType,
            "pageSize"   => 10,
        ];
        return $this->kmQueryPost('/admin/commonConfig/appConfig/list', $q);
    }

    public function appConfigPublish($configType = 'open_screen_ads')
    {

        $q = [
            "id"     => 11,
            "status" => 1,
        ];
        return $this->kmQueryPost('/admin/commonConfig/appConfig/publish', $q);
    }

    public function appConfigRelease($configType = 'open_screen_ads')
    {
        $query = [
            "configTypeList" => [
                $configType
//                'template_recommend',
//                'template_recommend_for_new_user',
            ],
        ];
        return $this->kmQueryPost('/admin/commonConfig/appConfig/release', $query);
    }

    public function strictSave()
    {
        $query = [
            'id'           => 7,
            'configType'   => 'APP_TEMPLATE_RECOMMEND',
            'configName'   => '每日模板推荐',
            'configKey'    => 'APP_TEMPLATE_RECOMMEND',
            'configRemark' => '每日模板推荐',
            'data'         => [
                'popup_switch' => 1,
                'popup_count'  => 5
            ]
        ];
        return $this->kmQueryPost('/admin/commonConfig/strictSave', $query);
    }


    public function getCommonConfig()
    {
        $query = [
            'configType' => 'APP_TEMPLATE_RECOMMEND',
        ];
        return $this->kmQueryPost('/admin/commonConfig/get', $query);
    }

    public function demo()
    {
        $query = [];
        return $this->kmQueryPost('', $query);
    }


}