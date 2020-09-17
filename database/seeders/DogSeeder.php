<?php

namespace Database\Seeders;

use App\Models\Dog;
use Illuminate\Database\Seeder;

class DogSeeder extends Seeder
{
    /**
     * php artisan make:seeder DogSeeder
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dog::factory()
            ->times(1000)
            ->create();
        dump("success");
    }
}
