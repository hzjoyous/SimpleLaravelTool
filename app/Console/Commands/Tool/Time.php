<?php

namespace App\Console\Commands\Tool;

use Illuminate\Console\Command;

class Time extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'time';

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
        $this->line(date('Y-m-d H:i:s',1588377533));
        $this->line(time());
        return ;
    }
}
