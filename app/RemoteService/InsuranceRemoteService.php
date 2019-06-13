<?php
declare(strict_types=1);

namespace App\RemoteService;

use App\RemoteService\BaseLib\BaseRemoteService;

class InsuranceRemoteService extends BaseRemoteService
{
    public function getCarefreeInsuranceByOrderIds($orderIds)
    {
        return $this->get('/CarefreeInsurance/getCarefreeInsuranceByOrderIds', [
            'orderIds' => $orderIds,
        ]);
    }

    public function getCarefreeInsuranceInfoByOrderId($orderId)
    {
        return $this->get('/CarefreeInsurance/GetCarefreeInsuranceInfoByOrderId', [
            'orderId' => $orderId,
        ]);
    }
}
