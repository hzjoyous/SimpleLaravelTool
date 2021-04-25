<?php

namespace App\Console\Commands\Tool;

use Faker\Factory;
use Illuminate\Console\Command;

class MakeFaker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:md';

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
        $faker = Factory::create();
        $addressList = [];
        for ($i = 0; $i < 10; $i++) {
            $addressList[] = $faker->city;
        }
        $dataList = [];
        for ($i = 0; $i < 30; $i++) {
            $dataList[] = [
                'name' => $faker->name,
                'count' => $faker->numberBetween(10, 100),
                'purchasePrice' => $faker->numberBetween(10, 100),
                'sellingPrice' => $faker->numberBetween(10, 100),
                'remarks' => $faker->text
            ];
        }
        echo json_encode($dataList);
        return 0;
    }
}
