<?php
declare(strict_types=1);
namespace App\RemoteService;
use App\RemoteService\BaseLib\BaseRemoteService;
use App\Implementation\Infrastructure\Service\Translator\CashPledgeTranslator;

class CashPledgeRemoteService extends BaseRemoteService
{
    public function row2Entity()
    {
        $translator = new CashPledgeTranslator();

        return function ($response) use ($translator) {
            return array_map(function ($response) use ($translator) {
                return $translator->getCashPledge($response);
            }, $response);
        };
    }

    public function getCashPledgeList(array $orderIds,$userRole='fk')
    {
        return $this->postParams('/CashPledge/GetCashPledgeList', [
            'orderIds' => $orderIds,
            'userRole' => $userRole,
        ], $this->row2Entity());
    }
}
