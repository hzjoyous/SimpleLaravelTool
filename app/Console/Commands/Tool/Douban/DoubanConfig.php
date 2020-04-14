<?php

namespace App\Console\Commands\Tool\Douban;

class DoubanConfig
{
    private $groupId;
    private $start;
    private $end;
    private $insertTime;
    private $groupList;

    public function __construct($configFilePath)
    {
        $config = file_get_contents($configFilePath);
        $config = json_decode($config, true);
        foreach (['groupId', 'start', 'end', 'insertTime',] as $waitCheckKey) {
            if (!array_key_exists($waitCheckKey, $config)) {
                throw new \Exception("config 缺失 $waitCheckKey 字段");
            }
        }
        $this->groupId  = (string) $config['groupId'];
        $this->start = $config['start'];
        $this->end = $config['end'];
        $this->insertTime = $config['insertTime'];
        $this->groupList = $config['groupList'];
    }

    public function getGroupId()
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
