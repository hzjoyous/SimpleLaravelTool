<?php


namespace App\Service;


class QQUtil

{
    public static function usernameEncode(array $friendList): array
    {
        return array_reduce($friendList, function ($pre, $item) {
            $userInfo = explode('#', $item['remark']);
            $tVar = 0;
            $userInfo = array_reduce($userInfo, function ($pre, $item) use (&$tVar) {
                if ($tVar === 0) {
                    $tVar += 1;
                    // 分解前缀
                    $pItem1 = explode('.', $item);
                    $pItem2 = explode('·', $item);
                    if (count($pItem1) > count($pItem2)) {
                        $pItem = $pItem1;
                    } else {
                        $pItem = $pItem2;
                    }
                    if (count($pItem) > 1) {
                        if ($pItem[0] == 'R') {
                            $pre['R'] = true;
                        }
                        array_splice($pItem, 0, 1);
                        $pre['name'] = implode('', $pItem);
                    } else {
                        $pre['name'] = $pItem[0];
                    }
                } else {
                    $pItem = explode(':', $item);
                    $tag = $pItem[0];
                    $tagInfo = $pItem[1] ?? '';
                    switch ($tag) {
                        case 'T':
                            $pre['T'] = true;
                            break;
                        case 'S':
                            $pre['S'] = true;
                            break;
                        case 'F':
                            $pre['F'] = true;
                            break;
                        case 'D':
                            $pre['D'] = true;
                            break;
                        case 'R':
                            $pre['R'] = true;
                            break;
                        case 'Z':
                            $pre['Z'] = true;
                            break;
                        default:
                            throw new \Exception('资料部分解析失败');
                    }
                }
                return $pre;
            }, []);
            $item['aUserInfo'] = $userInfo;
            $pre[] = $item;
            return $pre;
        }, []);
    }
}




