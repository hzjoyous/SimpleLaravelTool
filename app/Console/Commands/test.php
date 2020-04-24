<?php

namespace App\Console\Commands;

use App\Console\Commands\Tool\str;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:test';

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

//        $client = new Client([
//            'base_uri' => 'https://aip.baidubce.com/oauth/2.0/token',
//            'timeout' => 10.0,
//            'http_errors' => false,
//            'verify' => false,
//        ]);
//
//        $result = $client->request('post', "/oauth/2.0/token", [
//            'query' => [
//                'grant_type' => 'client_credentials',
//                'client_id' => 'LEVlCI9ymTsByK5PPIis41zV',
//                'client_secret' => 'dsEzNQOnpyZ7TK2xxP2ouKaPrjtPFyhQ'
//            ]
//        ])->getBody();
//        dump((string)$result);
        $result = '{"refresh_token":"25.2f7859e52ab808226331e25136d66fdd.315360000.1902897949.282335-19549928","expires_in":2592000,"session_key":"9mzdAqAfg7R2SXyX5oN2HN4kl\/Ix87YLqn9aMVAhZ9pczr5u95dLAjhYHNwEhs6gV\/squ4Oec3tdphLJp+ASN1\/Oa5UEyg==","access_token":"24.9b509b5640882f31ce29f4152f660768.2592000.1590129949.282335-19549928","scope":"public brain_all_scope unit_\u7406\u89e3\u4e0e\u4ea4\u4e92V2 wise_adapt lebo_resource_base lightservice_public hetu_basic lightcms_map_poi kaidian_kaidian ApsMisTest_Test\u6743\u9650 vis-classify_flower lpq_\u5f00\u653e cop_helloScope ApsMis_fangdi_permission smartapp_snsapi_base iop_autocar oauth_tp_app smartapp_smart_game_openapi oauth_sessionkey smartapp_swanid_verify smartapp_opensource_openapi smartapp_opensource_recapi qatest_scope1 fake_face_detect_\u5f00\u653eScope vis-ocr_\u865a\u62df\u4eba\u7269\u52a9\u7406 idl-video_\u865a\u62df\u4eba\u7269\u52a9\u7406","session_secret":"23fcb6ea1ed19c53b5ed12e738ece07f"}';
        $result = json_decode((string)$result, true);
        $accessToken = $result['access_token'];
        dump($accessToken);
        $aiClient = new Client([

            'base_uri' => 'https://aip.baidubce.com',
            'timeout' => 10.0,
            'http_errors' => false,
            'verify' => false,
        ]);
        $result = $aiClient->request('post', '/rpc/2.0/unit/service/chat', [
            'query' => [
                'access_token' => $accessToken
            ],
            'json' =>
                [
                    'log_id' => 'UNITTEST_10000',
                    'version' => '2.0',
                    'service_id' => 'S29166',
                    'session_id' => 'xxx',
                    'request' =>
                        [
                            'query' => '王者荣耀',
                            'user_id' => '88888',
                        ],
                    'dialog_state' =>
                        [
                            'contexts' =>
                                [
                                    'SYS_REMEMBERED_SKILLS' => []
                                ],
                        ],
                ]

        ])->getBody();
        dump(json_decode((string)$result,true));
        dump(json_decode((string)$result,true)['result']['response_list'][0]['action_list']);
        return;
    }
}
