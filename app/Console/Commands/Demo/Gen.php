<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;
use ReadAsArr\ReadFile;

class Gen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xdemo:g';

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
        foreach (ReadFile::asArr(__DIR__ . '/tmp/0.html') as $value) {
            echo $value . PHP_EOL;
        }
        return 0;
    }
}
