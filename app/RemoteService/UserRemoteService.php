<?php
declare(strict_types=1);

namespace App\RemoteService;
use App\RemoteService\BaseLib\BaseRemoteService;

use App\Implementation\Infrastructure\Service\Translator\UserTranslator;

class UserRemoteService extends BaseRemoteService
{
    public function raw2Entity()
    {
        $translator = new UserTranslator();

        return function ($content) use ($translator) {
            return array_map(function ($data) use ($translator) {
                return $translator->toSubmitterFromResponse($data);
            }, $content);
        };
    }

    public function getUserNamesByUserIds( array $userIds)
    {
        return $this->get('/user/getUserNamesByUserIds', array(
            'userIds'  => $userIds,
        ), $this->raw2Entity());
    }

    public function getUserExtraAttribute(string $userId)
    {
        return $this->postParams('/user/getUserExtraAttribute', array(
            'userId' => $userId,
        ));
    }

    public function getUser(string $userId, bool $method = false)
    {
        return $this->postParams('/user/getUser4BookOrderV2', [
            'userId' => $userId,
            'method' => $method
        ]);
    }

    /**
     * @param string $userId
     * @return BaseLib\RemoteServiceResponse
     */
    public function getUserInfo(string $userId)
    {
        return $this->postJson('/user/getUserInfo', [
            'userId' => $userId
        ]);
    }

}
