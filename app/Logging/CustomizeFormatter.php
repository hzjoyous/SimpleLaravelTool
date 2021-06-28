<?php


namespace App\Logging;


use App\Service\TraceIdMaker;

class CustomizeFormatter
{

    public function __invoke($logger)
    {
        $logger->pushProcessor(function ($item) {
            if (array_key_exists('message', $item)) {
                $item['message'] = $item['message'] . ':' . TraceIdMaker::make();
            }
            return $item;
        });
    }
}
