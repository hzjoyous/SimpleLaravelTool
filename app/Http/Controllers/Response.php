<?php

declare(strict_types=1);

namespace App\Http\Controllers;

trait Response
{
    /**
     * @param mixed $data
     * @return array
     */
    public function simpleResponse(...$data)
    {
        return [
            'code' => 0,
            'errMsg' => '',
            'data' => count($data) === 1 ? head($data) : $data,
            'timeStamp' => time(),
        ];
    }
}
