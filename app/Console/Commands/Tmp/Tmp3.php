<?php

namespace App\Console\Commands\Tmp;

use Illuminate\Console\Command;

class Tmp3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zz:t3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '临时命令3';

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
        return 0;
    }
}
