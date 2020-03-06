<?php
declare(strict_types=1);

namespace App\RemoteService;


use App\RemoteService\BaseLib\BaseRemoteService;

class VBotRemoteService extends BaseRemoteService
{
    const friends   = 'friends';
    const groups    = 'groups';
    const members   = 'members';
    const specials  = 'specials';
    const officials = 'officials';

    public function getAllFriends()
    {

        $searchBody = [
            'action' => 'search',
            'params' =>
                [
                    'type'   => self::friends,
                    'method' => 'getObject',
                    "filter" => [
                        '',
                        "NickName",
                        true,
                        true
                    ]
                ],
        ];

        return $this->postJson('', $searchBody);

    }

    public function search($nickName = 'sss')
    {

        $searchBody = [
            'action' => 'search',
            'params' =>
                [
                    'type'   => self::friends,
                    'method' => 'getObject',
                    "filter" => [
                        $nickName,
                        "NickName",
                        true,
                        true
                    ]
                ],
        ];

        return $this->postJson('', $searchBody);

    }


    public function send($userName,$content)
    {
        $messageBody = [
            'action' => 'send',
            'params' =>
                [
                    'type'     => 'text',
                    'username' => $userName,
                    'content'  => $content,
                ],
        ];
        $cardBody    = [
            'action' => 'send',
            'params' =>
                [
                    'type'     => 'card',
                    'username' => '@@5e200a8c6e4fefcc7e5f86ebf6b585c85bb8dd066c32a3b28b4b5cf49cb5d6e5',
                    'content'  => 'hanson1994,API 测试',
                ],
        ];

        return $this->postJson('', $messageBody);
    }
}
