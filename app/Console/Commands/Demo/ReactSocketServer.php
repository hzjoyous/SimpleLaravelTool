<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;
use React\EventLoop\Factory;
use React\Socket\ConnectionInterface;
use React\Socket\Server;

class ReactSocketServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zdemo:rsocketserver';

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
        $socket = new Server('0.0.0.0:8080', $loop);

        $socket->on('connection', function (ConnectionInterface $connection) {
            $connection->write("Hello " . $connection->getRemoteAddress() . "!\n");
            $connection->write("Welcome to this amazing server!\n");
            $connection->write("Here's a tip: don't say anything.\n");

            $connection->on('data', function ($data) use ($connection) {
                $connection->close();
            });
        });

        $loop->run();
        return 0;
    }
}
