<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Tmp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string $signature
     */
    protected $signature = 'z:z';

    /**
     * The console command description.
     *
     * @var string $description
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
        $this->line(config('simple.douban.s.userId',''));;
        $this->t();
        $arr = array_unique([]);
        dump($arr);
        return;
    }

    public function t(...$data)
    {
        var_dump($data);
        $a = true || $a = false;
        dump($a);
    }
}
