<?php

namespace App\Console\Commands\Tool;

use App\Mail\UserWelcome;
use Illuminate\Console\Command;
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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Mail::raw('easy', function ($message) {
            $message->subject("测试的邮件主题");
            // 指定发送到哪个邮箱账号
            $message->to("31792690@qq.com");
        });
        if (count(Mail::failures())) {
            $this->info("失败");
        } else {
            $this->info("成功");
        }


        Mail::to(['1054919923@qq.com'])->send(new UserWelcome());


        return;
    }

}
