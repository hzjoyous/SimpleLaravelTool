<?php

namespace App\Console\Commands\Demo;

use App\Utils\SimpleSystem;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Psr\Http\Message\ResponseInterface;
use React\EventLoop\Factory;
use React\Filesystem\Filesystem;
use React\Http\Browser;

class React extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zdemo:react';

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
        if(SimpleSystem::getOS()===SimpleSystem::OS_WIN){
            dd('文件io用的底层在不支持windows,这个demo切换到linux再试吧');
        }

        $simpleNum = 1;

        while ($simpleNum <= 3) {

            $loop = Factory::create();

            $client = new Browser($loop);

            $filesystem = Filesystem::create($loop);

            $i = 1;

            while ($i <= 5) {
                $client->get('http://api.nonodi.com/sleep')
                    ->then(function (ResponseInterface $response) use ($i, $simpleNum, $filesystem) {
                        dump("simpleNum:{$simpleNum},i:{$i}" . $response->getBody());
                        $filesystem
                            ->file(storage_path('tmp') . DIRECTORY_SEPARATOR . 'demo' . DIRECTORY_SEPARATOR . "{$simpleNum}_{$i}.json")
                            ->putContents($response->getBody())->then(function ($r) use ($i, $simpleNum) {
                                dump("simpleNum:{$simpleNum},i:{$i} putsuccess");
                            });
                    });
                $i += 1;
            }

            $loop->run();
            $this->info("simpleNum:{$simpleNum} run");
            $simpleNum += 1;
        }
        return ;
    }

    public function example1()
    {
        $loop = Factory::create();

        $list = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];

        // [2]
        $loop->addPeriodicTimer(1, function ($timer) use ($loop, &$list) {
            if (count($list) > 0) {
                $value = array_pop($list);
                dump('a');
            } else {
                $loop->cancelTimer($timer);
                $this->output->success('success');
            }
        });

        $loop->addPeriodicTimer(1, function ($timer) use ($loop, &$list) {
            if (count($list) > 0) {
                $value = array_pop($list);
                $client = new Client([
                    'base_uri' => 'http://api.nonodi.com'
                ]);
                $sstr = (string) $client->get('/sleep')->getBody();
                dump('b' . $sstr);
            } else {
                $loop->cancelTimer($timer);
                $this->output->success('success');
            }
        });

        $loop->addPeriodicTimer(1, function ($timer) use ($loop, &$list) {
            if (count($list) > 0) {
                $value = array_pop($list);
                $client = new Client([
                    'base_uri' => 'http://api.nonodi.com'
                ]);
                $sstr = (string) $client->get('/sleep')->getBody();
                dump('c' . $sstr);
            } else {
                $loop->cancelTimer($timer);
                $this->output->success('success');
            }
        });

        $loop->run();
    }
}
