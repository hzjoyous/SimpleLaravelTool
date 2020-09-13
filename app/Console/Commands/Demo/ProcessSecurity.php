<?php

namespace App\Console\Commands\Demo;

use App\Utils\SimpleSystem;
use Illuminate\Console\Command;

class ProcessSecurity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zdemo:pros';

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

        if(SimpleSystem::isWin()){
            $this->error("不支持win");
            return 0;
        }
        $SIGTERM_HANDLER = function ($sig) {
            switch ($sig) {
                case SIGINT:
                case SIGTERM:
                    die('安全退出成功' . PHP_EOL);
                    break;
                default:
                    break;
            }
        };
        \pcntl_signal(SIGTERM, $SIGTERM_HANDLER);
        \pcntl_signal(SIGINT, $SIGTERM_HANDLER);

        while(true){
            $this->line("我是一个死循环");
            sleep(1);

            $this->line("我是一个死循环2");
            sleep(1);

            $this->line("我是一个死循环3");
            sleep(1);

            \pcntl_signal_dispatch();

        }
        return 0;
    }
}
