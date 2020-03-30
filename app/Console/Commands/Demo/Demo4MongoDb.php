<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;
use MongoDB\Client;

class Demo4MongoDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:mongodb';

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
        // ext-mongodb
        // composer https://packagist.org/packages/mongodb/mongodb
        // desc https://docs.mongodb.com/php-library/current/
        
        $collection = (new Client())->test->users;

        $insertOneResult = $collection->insertOne([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'name' => 'Admin User',
        ]);

        printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());

        var_dump($insertOneResult->getInsertedId());
    }
}
