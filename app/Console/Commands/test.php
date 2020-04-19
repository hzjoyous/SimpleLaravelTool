<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $n = 700000000;
        $start = microtime(true);
        // $this->splicingStrV1($n);
        echo $this->fibonacci(36).PHP_EOL;
        // sleep(4);
        $end = microtime(true);
        echo ($end - $start);
    }

    public function splicingStrV1($n)
    {
        $msg = "msg";
        for ($i = 1; $i < $n; $i++) {
            $msg .= "msg";
        }
        $msg = "msg";
        return $msg;
    }

    public function fibonacci($n)
    {
        if ($n <= 1) {
            $res = 1;
        } else {
            $res = $this->fibonacci($n - 1) + $this->fibonacci($n - 2);
        }
        return $res;
    }
}
