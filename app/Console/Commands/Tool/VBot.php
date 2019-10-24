<?php

namespace App\Console\Commands\Tool;

use App\RemoteService\RemoteServiceFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Psr\Log\LogLevel;

class VBot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:vbot';

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

        $rs         = RemoteServiceFactory::getVBotRemoteService();

//        $friendList = $rs->search()->getResult();
        $friendList = $rs->getAllFriends()->getResult();

//        $userName = $friendList["friends"]["UserName"];
//        $NickName = $friendList["friends"]["NickName"];
//        $RemarkName = $friendList["friends"]["RemarkName"];
//        $RemarkPYQuanPin = $friendList["friends"]["RemarkPYQuanPin"];
//        $Province = $friendList["friends"]["Province"];
//        $City = $friendList["friends"]["City"];
//        $Sex = $friendList["friends"]["Sex"];
//        $lastStr = "5s后发起下次消息";
//        $str = "获取用户信息成功，性别:{$Sex},昵称:{$NickName},备注:{$RemarkName},昵称拼音全拼:{$RemarkPYQuanPin},所在城市:{$Province}.{$City}".$lastStr ;
//
//        $userName = '@bb7ca765d9a1c883dd61a5175d6902185df316d831863eb0c0f9577792373217';
//
//        $r = $rs->send($userName,$str)->getResult();
//        sleep(5);
//        for ($i =0 ;$i<3 ;$i++){
//            $str = "当前时间".Date('Y-m-d H:i:s');
//            $r = $rs->send($userName,$str.$lastStr)->getResult();
//            sleep(5);
//        }
//        $r = $rs->send($userName,$str.'发送结束')->getResult();

        dump($friendList);

        return;
    }
}
