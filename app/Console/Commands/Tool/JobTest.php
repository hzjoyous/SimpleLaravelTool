<?php

namespace App\Console\Commands\Tool;

use App\Jobs\JobDemo;
use Illuminate\Console\Command;

class JobTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:j';

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
        for ($i = 0; $i < 10; $i++) {
            $data = [
                'time' => date('Y-m-d H:i:s')
            ];
            dump($data);
            JobDemo::dispatch($data);
        }
        return 0;
    }
}
