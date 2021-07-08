<?php

namespace App\Console\Commands\Tmp;

use App\Models\User;
use Illuminate\Console\Command;

class Tmp3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zz:t3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '临时命令3';

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
    public function handle(): int
    {

        $o1 = User::query()->where([] );
        $o2= User::where([]);
        $this->info('上面一行是调用了 __call() ,判断没有后先调用 $this->newQuery() 之后调用 where，所以直接用的哥方法就好');
        dump(get_class($o1),get_class($o2));
        return 0;
    }
}
