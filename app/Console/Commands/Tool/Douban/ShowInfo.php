<?php

namespace App\Console\Commands\Tool\Douban;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class S0Tool extends Command
{
    use UtilTrait;

    const M_CLEAR = 'clear';
    const M_WORK = 'work';
    const M_STATE = 'state';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:douban:tool {m=none :运行模式,clear(清理)}';

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
     * @throws \Exception
     */
    public function handle()
    {
        $this->init();
        switch ($this->argument('m')) {
            case self::M_CLEAR:
                $fileSystem = new Filesystem();
                $fileSystem->cleanDirectory($this->doubanPath);
                $this->redis->flushAll();

                $this->info("clear finished");
                break;
            case self::M_WORK:
                $this->call('z:douban:group');
                $this->call('z:douban:topic', [
                    'mode' => 'slb'
                ]);
                $this->call('z:douban:topic', [
                    'mode' => 'slu'
                ]);
                $this->call('z:douban:show');
                break;
            case self::M_STATE:
                dump($this->redis->lLen($this->redisListKey));
                break;
            default:
                $this->info("no command");
                break;
        }
        return 0;
    }
}
