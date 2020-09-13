<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;

class Pipe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zdemo:pipe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'example: cat composer.json | php artisan demo:pipe';

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
        $fp = fopen('php://stdin', 'r');
        if ($fp) {
            while ($line = fgets($fp, 4096)) {
                echo $line;
            }
            fclose($fp);
        }
        return ;

    }
}
