<?php
/**
 * Created by PhpStorm.
 * User: hzj
 * Date: 2019/4/24
 * Time: 13:57
 */
declare(strict_types=1);

namespace App\RemoteService\ResponseFormat;


use App\Jobs\AlarmMail\AlarmMailAddressList;
use App\Service\EarlyWarningTLS;

class VipRemoteServiceResponseFormat implements BaseResponseFormat
{
    public function __invoke(string $content)
    {
        $result = [];
        $json   = json_decode($content, true);
        if (!is_array($json) || !$this->checkAttributeExist($json, ['errno', 'errno', 'data'])) {
            $result = [];
        } else {
            switch ($json['errno']) {
                case 0:
                    $result = $json['data'];
                    break;
                default:
                    break;
            }
        }
        return $result;
    }


    protected function checkAttributeExist($json, array $checks): bool
    {
        foreach ($checks as $check) {
            if (!array_key_exists($check, $json)) {
                return false;
            }
        }
        return true;
    }
}
