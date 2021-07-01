<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class TraceIdMakerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_idMaker()
    {
        $service = \App\Service\TraceIdMaker::getInstance();
        $t1 = $service->getNowCompleteTraceId();
        $t2 = $service->getNowCompleteTraceId();

        $this->assertTrue($t1!==$t2,'traceId不应一样');

    }
}
