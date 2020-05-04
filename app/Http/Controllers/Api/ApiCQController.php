<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\HttpClient\AipHttpClient;
use App\HttpClient\CQHttpClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiCQController extends Controller
{
    const MESSAGE_TYPE_PRIVATE = 'private';
    const MESSAGE_TYPE_GROUP = 'group';

    public function index(Request $request)
    {
        $client = new CQHttpClient();

        $requestArr = (array)json_decode($request->getContent(), true);

        Log::debug('message', $requestArr);

        $messageType = ($requestArr['message_type'] ?? 'other');
        $userId = $requestArr['user_id'] ?? '';
        $groupId = $requestArr['group_id'] ?? '';
        $message = $requestArr['message'] ?? '';

        if (strpos($message, 'CQ:image,file') !== false) {
            new NotFoundHttpException("NO SAY : CQ:image,file");
        }

        $aipClient = new AipHttpClient();
        switch ($messageType) {
            case self::MESSAGE_TYPE_PRIVATE:
                if ($userId) {
                    $requestArr = $aipClient->say($message, $userId);
                    $requestArr = (array)json_decode($requestArr, true);
                    $actionList = $requestArr['result']['response_list'][0]['action_list'] ?? [];
                    $counter = 0;
                    if (mt_rand(0, 1) === 1) {
                        foreach ($actionList as $value) {
                            $counter += 1;
                            $face = '[CQ:face,id=' . mt_rand(1, 182) . '] ';
                            if (mt_rand(0, 1) === 1) {
                                $face = $face . $face . $face;
                            }
                            $client->sendPrivateMsg($userId, $face . $value['say']);
                            if ($counter >= 2) {
                                break;
                            }
                        }
                    } else {
                        $client->sendPrivateMsg($userId, $actionList[0]['say']);
                    }
                }
                break;
            case self::MESSAGE_TYPE_GROUP:
                if (in_array($groupId, [])) {
                    break;
                }
                if ($groupId) {
                    $requestArr = $aipClient->say($message, $groupId);
                    $requestArr = (array)json_decode($requestArr, true);
                    $actionList = $requestArr['result']['response_list'][0]['action_list'] ?? [];
                    Log::debug('say', $actionList);
                    $actionCount = count($actionList);
                    $face = '';
                    if (mt_rand(0, 4) === 1) {
                        $face = '[CQ:face,id=' . mt_rand(1, 182) . '] ';
                        $face = $face . $face . $face;
                    }
                    $result = '';
                    if ($actionCount > 1) {
                        $result = $client->sendGroupMsg($groupId, $face . $actionList[1]['say']);
                    } else if ($actionList === 1) {
                        $result = $client->sendGroupMsg($groupId, $face . $actionList[0]['say']);
                    }
                    Log::debug('send', [$message, json_decode((string)$result, true)]);
                }
                break;
            default:
                break;
        }
        return
            [
                'this is api demo'
            ];
    }
}
