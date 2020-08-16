<?php

namespace App\Console\Commands\Tool\Study;

use Illuminate\Console\Command;

class EngTmp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:engTmp';

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
        $engStrStart = file_get_contents(__DIR__ . '/eng.txt');
        $engStr = str_replace("\n", ' ', $engStrStart);
        $wordArr = explode(' ', $engStr);
        $showWord = [];
        $showWord = array_map(function($item){
            return rtrim($item, '. \t\n\r\0\x0B,"');
        },$wordArr);
        dd($showWord);
    }
}
