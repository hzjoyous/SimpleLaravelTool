<?php

namespace App\Console\Commands\Tool\QQBot;

use App\Service\QQUtil;
use Exception;
use Illuminate\Console\Command;

class ZQQBotTool2 extends Command
{
    /**
     *  remark 命名规则
     * [前缀[.|·]][姓名]#[tag][:tagInfo][..[tag][:tagInfo]]
     *  前缀: Ztmp2020 | 临时好友
     *  前缀: Ztmp2019 | 临时好友
     *  前缀: R | remark is nickname no username
     *  tag: T 老师
     *  tag: S 专业方向（校园途径）
     *  tag: F 来源（校外途径）
     *  tag: D 区别（区分重名）
     *  tag: Z 特殊编码
     *  tag: R  | remark is nickname no username
     */

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:old:qqtool2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'qq格式化展示好友列表';

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
     *
     * @throws Exception
     */
    public function handle(): int
    {
        $tmpPath = storage_path('tmp');
        $inputFileName = $tmpPath . '/qqFriendList.json';
        $str = file_get_contents($inputFileName);
        $friendList = json_decode($str, true);
        $friendList = QQUtil::usernameEncode($friendList);
        dump($friendList);
        return 0;
    }


}
