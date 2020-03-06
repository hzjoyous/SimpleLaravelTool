<?php
/**
 * Created by PhpStorm.
 * User: hzj
 * Date: 2019/4/25
 * Time: 16:04
 */
declare(strict_types=1);

namespace App\RemoteService;

use App\RemoteService\BaseLib\BaseRemoteService;

class InvoiceRemoteService extends BaseRemoteService
{
    public function getInvoiceListByOrderIds(array $orderIds)
    {
        return $this->get('/Invoice/GetInvoiceCollection', [
            'orderIds' => $orderIds
        ]);
    }
}
