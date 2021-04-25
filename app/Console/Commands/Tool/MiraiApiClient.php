<?php

namespace App\Console\Commands\Tool;

use App\RemoteClient\HttpClientMiraiApi;
use Illuminate\Console\Command;

class MiraiApiClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:qqbot';

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

    protected ?HttpClientMiraiApi $client = null;

    public function init()
    {
        $this->client = new HttpClientMiraiApi();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->init();
        $this->info($this->client->getAbout());
        $this->client->CheckAndUpdateSessionClint('31792690');
        $result = $this->client->sendFriendMessage('774340277', "吃饭吃饭\n吃饭吃饭\n");
        dump($result);
        return 0;
    }

}
