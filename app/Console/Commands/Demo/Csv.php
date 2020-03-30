<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;

class Csv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'https://csv.thephpleague.com/';

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
    }
}
