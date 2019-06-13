<?php
declare(strict_types=1);

namespace App\RemoteService;

use App\RemoteService\BaseLib\BaseRemoteService;

class HouseKeeperRemoteService extends BaseRemoteService
{
    public function getIsSupportHouseKeeper($lodgeUnits)
    {
        return $this->get('/Housekeeper/GetIsSupport', [
            'lodgeUnits' => $lodgeUnits
        ]);
    }
}
