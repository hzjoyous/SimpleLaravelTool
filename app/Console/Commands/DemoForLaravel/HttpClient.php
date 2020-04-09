<?php

namespace App\Console\Commands\DemoForLaravel;

use Illuminate\Console\Command;

class HttpClient extends Command
{
    /**
     * The name and signature of the console command.
     * https://laravel.com/docs/7.x/http-client
     * @var string
     */
    protected $signature = 'demo:name';

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
    }
}
