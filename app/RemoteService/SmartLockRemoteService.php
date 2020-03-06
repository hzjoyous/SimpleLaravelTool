<?php
declare(strict_types=1);

namespace App\RemoteService;

use App\RemoteService\BaseLib\BaseRemoteService;

class SmartLockRemoteService extends BaseRemoteService
{
    public function getLockPrivilegeListByOrderIds($orderIds)
    {
        return $this->get('/BookOrder/GetPrivilegeByOrderIds', array(
            'orderIds' => $orderIds,
        ));
    }

    public function getSmartLockByOrderId($orderId, $userRole): RemoteServiceResponse
    {
        return $this->get('/BookOrder/GetSmartLockByOrderId', [
            'orderId'  => $orderId,
            'userRole' => $userRole,
        ]);
    }
}
