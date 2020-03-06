<?php
/**
 * Created by PhpStorm.
 * User: hzj
 * Date: 2019/4/16
 * Time: 14:35
 */
declare(strict_types=1);

namespace App\RemoteService;

use App\RemoteService\BaseLib\BaseRemoteService;

class OfflineServeCenterRemoteService extends BaseRemoteService
{
    /**
     * @param $luId
     * @return RemoteServiceResponse
     */
    public function isHaveOfflineServiceCenter($luId)
    {
        $result = $this->get('/api/order/serviceCenter/checkIsShowCenterSite', [
            'luId' => $luId
        ]);
        return $result;
    }

}
