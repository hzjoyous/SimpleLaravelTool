<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class DemoCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zdemo:cache';

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
        $value = Cache::get('key');
        dump($value);
        $value = Cache::get('key', null);
        dump($value);

        $result = Cache::put('keyQQ', 'value', 60);
        dump($result);
        $value = Cache::get('keyQQ');
        dump($value);
        $value = Cache::pull('keyQQ');
        dump($value);

        return 0;
    }
}
