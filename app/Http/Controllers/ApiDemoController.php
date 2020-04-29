<?php

namespace App\Http\Controllers;

use App\HttpClient\AipHttpClient;
use App\HttpClient\CQHttpClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiDemoController extends Controller
{

    public function getNull()
    {
        return [];
    }

    public function index(Request $request)
    {
        $client = new CQHttpClient();
        Log::debug('message', json_decode($request->getContent(), true));
        $requestArr = (array)json_decode($request->getContent(), true);
        $messageType = ($requestArr['message_type'] ?? 'other');
        $userId = ($requestArr['user_id'] ?? '');
        $groupId = $requestArr['group_id'] ?? '';
        $message = $requestArr['message'] ?? '';
        if (strpos($message, 'CQ:image,file') !== false) {
            return [
                '图片不予回复'
            ];
        }

        $aipClient = new AipHttpClient();
        switch ($messageType) {
            case 'private':
                if ($userId) {
                    $requestArr = $aipClient->say($message, $userId);
                    $requestArr = (array)json_decode($requestArr, true);
                    $actionList = $requestArr['result']['response_list'][0]['action_list'] ?? [];
                    $actionCount = count($actionList);
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
            case 'group':
                if (in_array($groupId, [])) {

                } else if ($groupId) {

                    $requestArr = $aipClient->say($message, $groupId);
                    $requestArr = (array)json_decode($requestArr, true);
                    $actionList = $requestArr['result']['response_list'][0]['action_list'] ?? [];
                    Log::debug('say', $actionList);
                    $actionCount = count($actionList);
                    $counter = 0;
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
                    Log::debug('send', [$message,json_decode((string)$result,true)]);

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

    public function rgps(Request $request)
    {
        return [
            $_REQUEST,
            $_SERVER,
            $requestArr = (array)json_decode($request->getContent(), true)
        ];
    }


    public function cookieLook()
    {
        setcookie("TestCookie", 'testCookie ' . date('Y-m-d H:i:s'));
        return $_COOKIE;
    }

    public function showCode()
    {
        $image = new VerificationCode(80, 20); //将类实例化为对象

        $image->show(); //调用函数

        // 如不适用下述方法返回，请使用die，否则header会被重置
        return response('', 200, ['content-type' => 'image/png']);
    }


    public function uploadFile()
    {
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);     // 获取文件后缀名
        if (
            in_array($_FILES["file"]["type"], [
                "image/gif", "image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png"
            ])
            && ($_FILES["file"]["size"] < 2048000)   // 小于 200 kb
            && in_array(strtolower($extension), $allowedExts)
        ) {
            if ($_FILES["file"]["error"] > 0) {
                return response([
                    "错误：: " . $_FILES["file"]["error"]
                ]);
            } else {
                is_dir(storage_path('upload')) || mkdir(storage_path('upload'));
                move_uploaded_file($_FILES["file"]["tmp_name"], storage_path("upload") . DIRECTORY_SEPARATOR . date('YMDhis') . $_FILES["file"]["name"]);
                return response([
                    "上传文件名: " . $_FILES["file"]["name"] . "<br>",
                    "文件类型: " . $_FILES["file"]["type"] . "<br>",
                    "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>",
                    "文件临时存储的位置: " . $_FILES["file"]["tmp_name"] . "<br>",
                    "文件存储在: " . "upload" . DIRECTORY_SEPARATOR . $_FILES["file"]["name"]
                ]);
            }
        } else {
            return response([
                "非法的文件格式"
            ]);
        }
    }
}

