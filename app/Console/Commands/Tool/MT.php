<?php

namespace App\Console\Commands\Tool;

use App\RemoteClient\MTClient;
use Illuminate\Console\Command;

class MT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:mt';

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
        $client = new MTClient();
        $client->reg();
        $result = $client->login();
        $result = json_decode($result,true);
//        $token = $result['token'];
//         $client->aApiNeedJwt($token);
        return 0;
    }
}
