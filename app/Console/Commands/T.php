<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use React\Promise\Deferred;

class T extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:t';

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
        $loop = \React\EventLoop\Factory::create();

        $server = new \React\Http\Server($loop, function (\Psr\Http\Message\ServerRequestInterface $request) {
            return new \React\Http\Message\Response(
                200,
                array(
                    'Content-Type' => 'text/plain'
                ),
                "Hello World!\n"
            );
        });

        $socket = new \React\Socket\Server('0.0.0.0:8080', $loop);
        $server->listen($socket);

        $loop->run();

        $deferred = new Deferred();

        $deferred->promise()
            ->then(function ($x) {
                echo '222'.PHP_EOL;
                return $x + 1;
            });
//        $p = $deferred->promise();
        $this->info(1);
        $deferred->resolve(1);
        $this->info(2);
        die();
        $t1 = (microtime(true));
        sleep(1);
        $t2 = (microtime(true));
        dd($t1,$t2,time());
        $list          = [5, 14, 31];
        $nowMonth      = (int)date('m');
        $nowYear       = (int)date('Y');
        $i             = 0;
        while (1) {
            $nowDay = $list[$i % 3];
            if ($nowDay == date('d', strtotime("$nowYear-" .
                    str_pad($nowMonth, 2, "0", STR_PAD_LEFT) . "-" .
                    str_pad($nowDay, 2, "0", STR_PAD_LEFT)))) {
                echo date('Y-m-d', strtotime("$nowYear-" .
                    str_pad($nowMonth, 2, "0", STR_PAD_LEFT) . "-" .
                    str_pad($nowDay, 2, "0", STR_PAD_LEFT)));
                echo PHP_EOL;
            } else {
                echo date('Y-m-01', strtotime("$nowYear-" .
                    str_pad($nowMonth, 2, "0", STR_PAD_LEFT) . "-" .
                    str_pad($nowDay, 2, "0", STR_PAD_LEFT)));
                echo PHP_EOL;
            }
            $i++;
            if($i%3==0){
                $nowMonth++;
            }
            if($nowMonth%13==0){
                $nowMonth=1;
                $nowYear+=1;
            }
            if($i>100){
                break;
            }
        }

        return 0;
    }

}
