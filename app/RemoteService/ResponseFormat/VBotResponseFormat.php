<?php
/**
 * Created by PhpStorm.
 * User: hzj
 * Date: 2019/4/24
 * Time: 13:57
 */
declare(strict_types=1);

namespace App\RemoteService\ResponseFormat;


class VBotResponseFormat implements BaseResponseFormat
{
    public function __invoke(string $content)
    {
        $result = null;
        $json = json_decode($content, true);
        if($json===false){
            $result = [];
        } else {
            $result = $json['result']??[];
        }
        return $result;
    }
}
