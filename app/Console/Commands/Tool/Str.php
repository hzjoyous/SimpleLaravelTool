<?php

namespace App\Console\Commands\Tool;

use Illuminate\Console\Command;

class str extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:str';

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

    const urlDecode = 'urlDecode';
    const json2Arr  = 'json2Arr';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        while (
            ($type = $this->choice('输入需要转换的类型(直接回车退出)',
                [self::urlDecode, self::json2Arr, null],
                null
            )
            )
            &&
            ($type !== null)
        ) {
            $this->output->title('string format ' . $type);
            while (
                ($str = $this->output->ask('请输入需要转换的字符串(直接回车返回上一级)', null))
                &&
                ($str !== null)
            ) {
                switch ($type) {
                    case self::urlDecode:
                        $str = urldecode($str);
                        break;
                    case self::json2Arr:
                        $str = var_export(json_decode($str, 1), 1);
                        break;
                    default:
                        $this->output->warning('所输入类型不支持');
                        break;
                }
                $this->output->text($str);
            }
        }

        $this->output->success('bye~');

        return;
    }
}
