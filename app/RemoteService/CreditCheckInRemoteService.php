<?php
declare(strict_types=1);

namespace App\RemoteService;
use App\RemoteService\BaseLib\BaseRemoteService;class CreditCheckInRemoteService extends BaseRemoteService
{
    public function getCreditSignInfoByOrderId($bookOrderId)
    {
        return $this->get('/CreditCheckIn/getCreditSignInfoByOrderId', [
            'orderId' => $bookOrderId
        ]);
    }

}
