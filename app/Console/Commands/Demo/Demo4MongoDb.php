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
    protected $signature = 'xdemo:mongodb';

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
        $this->extMongoDB();
        $this->libMongoDb();
        return ;
    }

    private function mongoDemo()
    {
        $this->info("show dbs;");
        $this->info("use test; //不存在即为创建");
        $this->info("db.dropDatabase()");
        $this->info("db.createCollection()");
    }

    private function extMongoDB()
    {
        $this->output->title('extMonogoDB demo');
        $this->info('$manager = new \MongoDB\Driver\Manager("mongodb://localhost:27017");
        dump($manager);');
        $manager = new \MongoDB\Driver\Manager("mongodb://localhost:27017");
        dump($manager);
        $this->line('');
        $this->line('');
        $this->line('');
    }

    private function libMongoDb()
    {
        // ext-mongodb
        // composer https://packagist.org/packages/mongodb/mongodb
        // desc https://docs.mongodb.com/php-library/current/

        $this->output->title('libMonogoDB demo');

        $client = new Client();
        /**
         * 下述代码等价 $client->test; 详情查看 \MongoDB\Client::__get()
         */
        $database = $client->selectDatabase('test');

        /**
         * 下述代码等价 $database->users; 详情查看 \MongoDB\Database::__get()
         */
        $userCollection = $database->selectCollection('users');

        // $userCollection = (new Client())->test->users;

        $this->info('单条数据插入演示');

        $insertOneResult = $userCollection->insertOne([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'name' => 'Admin User',
        ]);

        printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());

        dump($insertOneResult->getInsertedId());


        /**
         * @var \MongoDB\Model\BSONDocument $findOneReuslt
         */
        $findOneReuslt = $userCollection->findOne(['_id' => 1]);
        if ($findOneReuslt !== null) {
            $deleteResult = $userCollection->deleteOne(['_id' => 1]);
            printf("Deleted %d document(s)\n", $deleteResult->getDeletedCount());
        }


        $insertOneResult = $userCollection->insertOne(['_id' => 1, 'name' => 'Alice']);

        printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());

        dump($insertOneResult->getInsertedId());


        $deleteResult = $userCollection->deleteOne(['_id' => 1]);

        printf("Deleted %d document(s)\n", $deleteResult->getDeletedCount());
        $n = 1;
        $showNumber = 0;
        // 100000000
        // while ($n <= 1000000) {
        //     $i = 5325;
        //     $userInfoList =  [];
        //     while ($i--) {
        //         $userInfo = [
        //             '_id' => $n,
        //             'user_id' => $n++,
        //             'username' => 'Justine Stokes',
        //             'email' => 'magali.torp@example.org',
        //             'email_verified_at' => '2020-04-01 02:49:51',
        //             'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        //             'remember_token' => 'j69mv5hJaC',
        //             'created_at' => '2020-04-01 02:49:58',
        //             'updated_at' => '2020-04-01 02:49:58'
        //         ];
        //         $userInfoList[] = $userInfo;
        //         if ($n >= 100000000) {
        //             break;
        //         }
        //     }
        //     $insertManyResult = $userCollection->insertMany($userInfoList);
        //     $showNumber += 1;
        //     if ($showNumber === 20) {

        //         printf("Inserted %d document(s)\n", $insertManyResult->getInsertedCount() * 20);
        //         $showNumber = 0;
        //     }



        //     // dump($insertManyResult->getInsertedIds());
        // }
        // $zipConllection = $database->selectCollection('zip');

        // $userCollection->drop();
    }
}
