<?php

namespace App\Console\Commands\Xiaozhu;

use App\Model\Xz\ABGroup;
use App\Model\Xz\BookOrder;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Check extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xiaozhu:check';

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
        $this->check('100127701300');
        $this->getHttpClient();
        return;
    }

    public function check($id)
    {
        $bookOrders = BookOrder::where('id', $id)->get();
        $bookOrder  = $bookOrders[0] ?? null;
        /* @var $bookOrder BookOrder */
        $abGroup = ABGroup::where('objid', $id);
        dd($bookOrder, $abGroup);
    }


    protected $client;

    protected function getHttpClient()
    {
        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());
        $monolog = Log::channel();
        $stack->push(Middleware::log($monolog, new MessageFormatter()));
        $this->client = new Client([
            'base_uri'    => 'localhost:8082',
            'timeout'     => 30.0,
            'http_errors' => false,
            'handler'     => $stack
        ]);
        $this->client->request('GET', 'test');
    }


    /**
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function getDBManager()
    {
        $order = 'mysql.production';
        return DB::connection($order);
    }


}
