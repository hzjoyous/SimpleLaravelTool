<?php
/**
 * Created by PhpStorm.
 * User: hzj
 * Date: 2019/4/25
 * Time: 13:06
 */
declare(strict_types=1);

namespace App\RemoteService;
use App\RemoteService\BaseLib\BaseRemoteService;
use App\Implementation\Infrastructure\Service\Translator\BookOrderTranslator;


class BookOrderRemoteService extends BaseRemoteService
{
    public function buildBookOrderCallBack()
    {
        $translator = new BookOrderTranslator();

        return function ($response) use ($translator) {

            if (isset($response[0])) {
                return array_map(function ($order) use ($translator) {
                    return $translator->getBookOrder($order);
                }, $response);
            }

            return $response ? $translator->getBookOrder($response) : null;
        };
    }

    public function getSubOrders($parentId, $userId = 0)
    {
        return $this->get('/subOrders', [
            'parentId' => $parentId,
            'userId'   => $userId
        ]);
    }

    public function getOrderDetail($orderId)
    {
        return $this->get(
            '/order/detail',
            [
                'orderId' => $orderId
            ],
            function ($orderInfo) {
                if (isset($orderInfo['checkInSummary']['dayCount'])) {
                    $orderInfo['checkInSummary']['dayCount'] = (string)$orderInfo['checkInSummary']['dayCount'];
                }
                return $orderInfo;
            }
        );
    }

    public function getBookLandlordOrderListItem4Fd($orderId)
    {
        return $this->get('/order/cache4fdlist', [
            'orderId' => $orderId,
        ],$this->buildBookOrderCallBack());
    }

    public function getBookLandlordOrderListItem4Fk($orderId)
    {
        return $this->get('/order/cache4fklist', [
            'orderId' => $orderId,
        ],$this->buildBookOrderCallBack());
    }


    public function calculatePrice(
        $submitterId, $luId, $parentOrderId, $roomNum, $orderCreateTime,
        $checkInDate, $checkOutDate, $usedCouponAmount, $prepayRate, array $dayPriceList,
        $currency, $cleanFeeInfo, $addTenantFee, $tenantTechnologyFeeRate, $landlordTechnologyFeeRate,
        $cashPledgeAmount, $invoiceChargeAmount, $accidentInsuranceChargeAmount, $cancelInsuranceChargeAmount, $orderId = '',
        $needSave = false, $needReCalculatePromotion = true, $isOrderUseVip = false
    )
    {
        return $this->postJson('/order/calculatePrice', [
            'submitterId'                   => $submitterId,
            'luId'                          => $luId,
            'orderId'                       => $orderId,
            'parentOrderId'                 => $parentOrderId,
            'roomNum'                       => $roomNum,
            'orderCreateTime'               => $orderCreateTime,
            'checkInDate'                   => $checkInDate,
            'checkOutDate'                  => $checkOutDate,
            'usedCouponAmount'              => $usedCouponAmount,
            'prepayRate'                    => $prepayRate,
            'dayPriceList'                  => $dayPriceList,
            'currency'                      => $currency,
            'cleanFeeInfo'                  => $cleanFeeInfo, //['amount' => '', 'isSupport' => 'yes'],
            'addTenantFee'                  => $addTenantFee,
            'needSave'                      => $needSave,
            'tenantTechnologyFeeRate'       => $tenantTechnologyFeeRate,
            'landlordTechnologyFeeRate'     => $landlordTechnologyFeeRate,
            'cashPledgeAmount'              => $cashPledgeAmount,
            'invoiceChargeAmount'           => $invoiceChargeAmount,
            'accidentInsuranceChargeAmount' => $accidentInsuranceChargeAmount,
            'cancelInsuranceChargeAmount'   => $cancelInsuranceChargeAmount,
            'needReCalculatePromotion'      => $needReCalculatePromotion,
            'isOrderUseVip'                 => $isOrderUseVip
        ]);
    }
}
