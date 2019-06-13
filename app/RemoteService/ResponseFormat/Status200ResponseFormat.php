<?php
/**
 * Created by PhpStorm.
 * User: hzj
 * Date: 2019/4/24
 * Time: 13:57
 */
declare(strict_types=1);

namespace App\RemoteService\ResponseFormat;


class Status200ResponseFormat implements BaseResponseFormat
{
    public function __invoke(string $content)
    {
        $result = null;
        $json = json_decode($content, true);
        if (is_null($json) || !isset($json['status']) || !array_key_exists('content', $json)) {
            $result = null;
        } else{
            switch ($json['status']) {
                case 200:
                    $result = $json['content'];
                    break;
                default:
                    break;
            }
        }
        return $result;
    }
}
