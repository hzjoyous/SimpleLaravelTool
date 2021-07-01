<?php

namespace App\Console\Commands\Demo;

use App\Service\SystemManager;
use Illuminate\Console\Command;

class Fork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xdemo:fork';

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
        if (SystemManager::isLinux()) {
            $this->error("not linux");
            return;
        }

        $pid = pcntl_fork();
        //父进程和子进程都会执行下面代码
        if ($pid == -1) {
            //错误处理：创建子进程失败时返回-1.
            die('could not fork');
        } else if ($pid) {
            //父进程会得到子进程号，所以这里是父进程执行的逻辑
            pcntl_wait($status); //等待子进程中断，防止子进程成为僵尸进程。
        } else {
            //子进程得到的$pid为0, 所以这里是子进程执行的逻辑。
        }

        return;
    }
}
