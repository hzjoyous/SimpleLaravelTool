<?php

namespace App\Console\Commands;

use App\HttpClient\AipHttpClient;
use Illuminate\Console\Command;

class Tmp extends Command
{
    /**
     * redis-cli
     * flushall
     */
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

        file_put_contents("ceshi.csv","数据1,数据2,数据3,数据4,数据5,数据6,数据7".PHP_EOL,8);
        for($i = 0;$i<=100;$i++){
            file_put_contents("ceshi.csv","$i,2,3,4,5,6,7".PHP_EOL,8);
        }
        return ;
    }
}
