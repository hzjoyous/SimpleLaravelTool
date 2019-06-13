<?php

namespace App\Console\Commands\XiaoZhu;

use App\RemoteService\ZRemoteServiceF;
use Illuminate\Console\Command;
use Symfony\Component\VarDumper\VarDumper;

class Order extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xiaozhu:order';

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
        $userId          = '14304713901';
        $zRemoteServiceF = new ZRemoteServiceF('testEnv23');
        $s               = $zRemoteServiceF->getVipRemoteService();
        $result          = $s->getUserVipInfoByUserId($userId)->getResult();
        VarDumper::dump($result);
        $results = $s->getVipListByOrderIdAndState($userId, '0')->getResult();
        foreach ($results as $result) {
            $cancelR = $s->cancelOpenVipOrder($result['channelBizId'])->getContent();
            //dump($result);
            dump(json_decode($cancelR));
        }
        $this->output->success('You have a new command! Now make it your own! Pass --help to see your options.');
        return;
    }
}
