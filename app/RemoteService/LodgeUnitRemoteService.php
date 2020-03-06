<?php
/**
 * Created by PhpStorm.
 * User: hzj
 * Date: 2019/4/11
 * Time: 15:05
 */
declare(strict_types=1);

namespace App\RemoteService;

use App\RemoteService\BaseLib\BaseRemoteService;
use App\Implementation\Infrastructure\Service\Translator\LodgeUnitTranslator;

class LodgeUnitRemoteService extends BaseRemoteService
{
    public function raw2Entity()
    {
        $translator = new LodgeUnitTranslator();

        return function ($response) use ($translator) {
            // if ($expected == self::EXPECT_ARRAY) {
            return array_map(function ($response) use ($translator) {
                return $translator->getLodgeUnit($response);
            }, $response);
            // }

            // return $translator->getLodgeUnit(current($response));
        };
    }

    public function getLodgeUnit4Reserve($luIds, $checkInDate, $checkOutDate)
    {
        return $this->get('/lodgeUnit/getLodgeUnit4Reserve', array(
            'luId'         => $luIds,
            'checkInDate'  => $checkInDate,
            'checkOutDate' => $checkOutDate,
        ), $this->raw2Entity());
    }

    public function getLodgeUnit(array $luId)
    {
        return $this->get('/lodgeUnit/getLodgeUnit', array(
            'luId' => $luId
        ), $this->raw2Entity());
    }
}
