<?php

namespace App\Console\Commands\Tool;

use App\Mail\UserWelcome;
use Illuminate\Console\Command;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class Email extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:email';

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

    // todo ceshi 
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Mail::raw('easy', function ($message) {
            $message->subject("异常邮件:ip更换提醒");
            // 指定发送到哪个邮箱账号
            $message->to(env('MAIL_USERNAME'));
        });
        if (count(Mail::failures())) {
            $this->info("失败");
        } else {
            $this->info("成功");
        }
        

//        Mail::to(['1054919923@qq.com'])->send(new UserWelcome());
//        $to = 'hanzhijie@xiaozhu.com';
//        Mail::send('email.email', ['data' => 'this is a test Email ! by SCORT !!!'], function ($m) use($to) {
//            /* @var $m Message*/
//            $m->from('1054919923@qq.com', 'name')
//                ->to($to)
//                ->subject('title');
//        });
        return;
    }

}
