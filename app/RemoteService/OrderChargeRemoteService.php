<?php
declare(strict_types=1);

namespace App\RemoteService;
use App\RemoteService\BaseLib\BaseRemoteService;class OrderChargeRemoteService extends BaseRemoteService
{
    public function getOrderPriceInfo($orderId)
    {
        return $this->get("/getOrderPriceInfo/{$orderId}");
    }

    public function saveOrderPriceItem(array $saveOrderPriceItem)
    {
        return $this->get("/saveOrderPriceItem", array_map(function ($item) {
            return ['orderId'             => $item['orderId'],
                    'parentOrderId'       => $item['parentOrderId'],
                    'type'                => $item['type'],
                    'prepayRate'          => $item['prepayRate'],
                    'showTotalPrice'      => $item['showTotalPrice'],
                    'showPrepayPrice'     => $item['showPrepayPrice'],
                    'originalTotalPrice'  => $item['originalTotalPrice'],
                    'originalPrepayPrice' => $item['originalPrepayPrice'],
                    'actualTotalPrice'    => $item['actualTotalPrice'],
                    'actualPrePayPrice'   => $item['actualPrePayPrice'],
                    'actualPrePaidPrice'  => $item['actualPrePaidPrice'],
                    'landlordEditedPrice' => $item['landlordEditedPrice']];
        }, $saveOrderPriceItem));
    }
}
