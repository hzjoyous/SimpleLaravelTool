<?php

namespace App\Console\Commands\Tool;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CronTab2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:cron2';

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
        $start = microtime(true);
        $end   = microtime(true);
        Log::debug("cron2 startTime is {$start} and use " . ($end - $start));
        return;

    }
}
