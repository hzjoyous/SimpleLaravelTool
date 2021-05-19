<?php

namespace App\Console\Commands\Tool;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CronTab extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:cron';

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
     * @return int
     */
    public function handle(): int
    {
        $start = microtime(true);
        sleep(5);
        $end   = microtime(true);
        Log::debug("cron1 startTime is {$start} and use " . ($end - $start));
        return 1;

    }
}
