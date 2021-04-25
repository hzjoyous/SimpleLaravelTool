<?php

namespace App\Console\Commands\Work;

use App\I\Index;
use App\RemoteClient\KClient;
use App\RemoteClient\KMClient;
use Illuminate\Console\Command;

class zk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:k';

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
        (new Index())->index();
        return 0;
    }


}
