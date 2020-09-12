<?php

namespace App\Console\Commands\Demo;

use App\Utils\SimpleSystem;
use Illuminate\Console\Command;

class Fork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
        //
        if (SimpleSystem::getOS() !== SimpleSystem::OS_LINUX) {
            $this->error("not linux");
            return;
        }

        return;
    }
}
