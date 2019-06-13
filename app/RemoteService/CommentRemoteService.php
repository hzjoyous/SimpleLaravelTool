<?php
declare(strict_types=1);

namespace App\RemoteService;
use App\RemoteService\BaseLib\BaseRemoteService;

class CommentRemoteService extends BaseRemoteService
{
    public function getCommentStatusByOrderIds($orderIds)
    {
        return $this->get('/GetCommentStatusByBookOrderIdArr', [
            'bookOrderIdArray' => $orderIds
        ]);
    }
}
