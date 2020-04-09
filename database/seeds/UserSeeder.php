<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10) . '@gmail.com',
            'password' => Hash::make('password'),
        ]);
        // $i = 100;
        // $i = 1;
        // while ($i--) {
            // factory(App\User::class, 100)->create();
            // dump("插入100");
            // dump(microtime(true) - LARAVEL_START);
        // }

        try {

            DB::beginTransaction();
        // DB::insert();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
