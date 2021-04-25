<?php

namespace App\Console\Commands\Work;

use Illuminate\Console\Command;

class T extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:t';

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
    public function handle()
    {
        $i = 100;
        while ($i--) {
            echo 1;
            usleep(1000000);
        }
        return 0;
    }
}
