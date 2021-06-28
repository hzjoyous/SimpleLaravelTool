<?php


namespace App\Service;


class TraceIdMaker
{
    protected static ?TraceIdMaker $inc = null;

    public static function getInstance(): TraceIdMaker
    {
        if (self::$inc === null) {
            self::$inc = new self();
        }
        return self::$inc;
    }

    public static function make(): string
    {
        return self::getInstance()->getNowCompleteTraceId();
    }


    protected string $commonTraceId;

    protected int $stop = 0;

    protected function __construct()
    {
        $this->commonTraceId = $this->createTraceId();
    }

    protected function createTraceId(): string
    {
        return md5(uniqid(mt_rand(), true));
    }

    public function getNowCompleteTraceId(): string
    {
        $this->stop += 1;
        return $this->commonTraceId . ':' . str_pad($this->stop, 3, '0', STR_PAD_LEFT);
    }
}
