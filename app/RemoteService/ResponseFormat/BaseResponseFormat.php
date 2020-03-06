<?php
/**
 * Created by PhpStorm.
 * User: hzj
 * Date: 2019/4/24
 * Time: 13:58
 */
declare(strict_types=1);

namespace App\RemoteService\ResponseFormat;


interface BaseResponseFormat
{
    public function __invoke(string $content);
}
