<?php

namespace App\Console\Commands\Tool\Douban;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ShowInfo extends Command
{
    use UtilTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:douban:tool';

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
     * @throws Exception
     */
    public function handle(): int
    {
        Cache::flush();
//        $this->init();
//        dump($this->redis->lLen($this->redisListKey));
        return 0;
    }
}
