<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;
use React\EventLoop\Factory;
use React\Socket\ConnectionInterface;
use React\Socket\Connector;
use React\Socket\Server;
use React\Stream\WritableResourceStream;

class ReactSocketClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zdemo:rsocketclient';

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
        $loop = Factory::create();
        $connector = new Connector($loop);

        $connector->connect('127.0.0.1:8080')->then(function (ConnectionInterface $connection) use ($loop) {
            $connection->pipe(new WritableResourceStream(STDOUT, $loop));
            $connection->write("Hello World!\n");
        });

        $loop->run();
        return 0;
    }
}
