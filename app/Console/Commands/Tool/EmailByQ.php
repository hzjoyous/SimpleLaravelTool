<?php

namespace App\Console\Commands\Tool;

use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class EmailByQ extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:SendEmailByQ';

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
        $to = 'hanzhijie@xiaozhu.com';
        Mail::send('email.email', ['data' => 'this is a test Email ! by SCORT !!!'], function ($m) use($to) {
            /* @var $m Message*/
            $m->from('1054919923@qq.com', 'name')
                ->to($to)
                ->subject('title');
        });
        return ;
    }
}
