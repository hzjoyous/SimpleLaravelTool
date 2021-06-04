<?php

namespace App\Console\Commands\Tool;

use Illuminate\Console\Command;

class MakeDayTodo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:makedaytodo';

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
        $day     = 30;
        $weekArr = [
            "星期日",
            "星期一",
            "星期二",
            "星期三",
            "星期四",
            "星期五",
            "星期六"
        ];
        $this->newLine();
        for ($i = $day; $i >= 0; $i--) {
            $timeStamp = time() + 86400 * $i;

            $w = date("w", $timeStamp);
            $this->info('# ' . date('Y/m/d', $timeStamp) . ' ' . $weekArr[$w]);
            if(in_array($w,[1,6])){
                $this->newLine();
            }
        }
        $this->newLine();
        return 0;
    }
}
