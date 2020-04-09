<?php

namespace App\Console\Commands\Tool;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class ZQQBotTmp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:zqqbotTmp';

    protected $accessToken = "hzjmytoken";

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
        $this->init();
    }

    private  $client = null;

    public function init()
    {
        $webHook = 'http://127.0.0.1:6701';

        $this->client = new Client([
            'base_uri' => $webHook,
            'timeout' => 10.0,
            'http_errors' => false,
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        try {

            $webHook = 'http://127.0.0.1:6701';

            // $response = $client->request('get', '/get_group_list', [
            //     'query' => [
            //         'access_token' => 'hzjmytoken',
            //     ]
            // ]);
            // $data = json_decode($response->getBody(), true);
            // dump($data);
            $groupIdD  = '';
            
            
            while(true){

                
                $messageList = [
""
                    
                    
                ];
                foreach($messageList as $message){
                    $result = $this->sendGroup($message,$groupIdD);
                }
                dump(json_encode($result->getBody(),true));

            }
        } catch (\Exception $e) {
            dump($e->getMessage());
        }
        return ;
    }

    public function sendGroup($message,$groupId)
    {
        $query = [
            'access_token' => $this->accessToken,
            'message' => $message,
            'group_id' => $groupId,
            'auto_escape'=>true
        ];

        $response = $this->client->request('get', '/send_group_msg', [
            'query' => $query
        ]);

        return $response;

    }
}
