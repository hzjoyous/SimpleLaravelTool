<?php


namespace App\RemoteService\VipRemoteService;


use App\RemoteService\BaseLib\BaseRemoteService;

class VipRemoteService extends BaseRemoteService
{

    public function getUserVipInfoByUserId($userId)
    {
        return $this->get('/internal/member/getMemberInfo', [
            'userId' => $userId
        ], function ($raw) {
            return new UserVipInfoFromVRS(
                $raw['isVip'] ?? 0,
                $raw['validityTime'] ?? '1970-01-01 01:01:01',
                $raw['vipType'] ?? 'member365',
                $raw['validityTime'] ?? '',
                [
                    'experience' => $raw['vipFee']['experience'] ?? 9999999,
                    'vip365'     => $raw['vipFee']['vip365'] ?? 9999999
                ]
            );
        });
    }

    const enum_vip_member365  = 'vip365';
    const enum_channel_bundle = 'bundle';

    public function createVip($userId, $orderId, $vipType, $channel)
    {
        return $this->postParams('/internal/member/createMember', [
            'userId'       => $userId,
            'vipType'      => $vipType,
            'channel'      => $channel,
            'channelBizId' => $orderId,
        ], function ($raw) {
            if ($raw) {
                return [
                    'vipId'        => $raw['vipId'],
                    'vipOrderId'   => $raw['memberOrderId'],
                    'objType'      => $raw['objType'],
                    'actualAmount' => $raw['actualAmount'],
                    'userId'       => $raw['userId'],
                ];
            } else {
                return [];
            }
        });
    }

    public function getVipOrderListByOrderId($orderId)
    {
        return $this->get('/internal/member/getOrderInfoByChannelBizId', [
            'channelBizId' => $orderId,
        ], function ($raw) {
            if ($raw) {
                $result = [
                    'status'       => $raw['status'],
                    'vipOrderId'   => $raw['vipOrderId'],
                    'actualAmount' => $raw['actualAmount']
                ];
            } else {
                $result = [];
            }
            return $result;
        });
    }

    public function getVipOrderListByUserId($userId)
    {
        return $this->get('/internal/member/getOrderInfoByChannelBizId', [
            'userId' => $userId,
        ], function ($raw) {
            if ($raw) {
                $result = [
                    'status'       => $raw['status'],
                    'vipOrderId'   => $raw['vipOrderId'],
                    'actualAmount' => $raw['actualAmount']
                ];
            } else {
                $result = [];
            }
            return $result;
        });
    }

    public function cancelOpenVipOrder($orderId)
    {
        return $this->postParams('/internal/member/cancellationOfMemberOrder', [
            'channel'       => 'bundle',
            'channelBizId' => $orderId,
        ]);
    }

    public function getVipListByOrderIdAndState($userId, $status)
    {
        return $this->get('/internal/member/getMemberOrderListByStatus', [
            'userId' => $userId,
            'status' => $status,
        ], function ($raws) {
            return array_map(function ($raw) {
                return [
                    "memberOrderId"   => $raw["memberOrderId"],
                    "channelBizId"    => (string)$raw["channelBizId"],
                    "userId"          => $raw["userId"],
                    "memberId"        => $raw["memberId"],
                    "status"          => $raw["status"],
                    "memberOrderType" => $raw["memberOrderType"],
                    "actualAmount"    => $raw["actualAmount"],
                    "createTime"      => $raw["createTime"],
                    "updateTime"      => $raw["updateTime"],
                ];
            }, $raws);
        });
    }
}
