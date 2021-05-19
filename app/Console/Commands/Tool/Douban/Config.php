<?php

namespace App\Console\Commands\Tool\Douban;

use App\Constants\RedisKey;
use Exception;
use Illuminate\Support\Facades\Cache;

class Config
{
    private string $groupId;
    private mixed  $start;
    private mixed  $end;
    private mixed  $insertTime;
    private mixed  $groupList;

    /**
     * @throws Exception
     */
    public function __construct($configFilePath)
    {
        $config = file_get_contents($configFilePath);
        $config = json_decode($config, true);
        foreach (['groupId', 'start', 'end'] as $waitCheckKey) {
            if (!array_key_exists($waitCheckKey, $config)) {
                throw new Exception("config 缺失 $waitCheckKey 字段");
            }
        }
        $DouBanCacheKey = RedisKey::DOUBAN_OP_TIME;
        $insertTime     = Cache::get($DouBanCacheKey);
        if (is_null($insertTime)) {
            Cache::put($DouBanCacheKey, time(), 3600);
            $insertTime = Cache::get($DouBanCacheKey);
        }

        $this->groupId    = (string)$config['groupId'];
        $this->start      = $config['start'];
        $this->end        = $config['end'];
        $this->insertTime = $insertTime;
        $this->groupList  = $config['groupList'];
    }

    public function getGroupId(): string
    {
        return $this->groupId;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function getInsertTime()
    {
        return $this->insertTime;
    }

    public function getGroupList()
    {
        return $this->groupList;
    }
}
