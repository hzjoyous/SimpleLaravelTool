<?php

namespace App\Console\Commands;

use App\Models\Dog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DemoSqlite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:sqlite';

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
        $this->output->title("show db_database_path");
        $this->info(env('DB_DATABASE', database_path('database.sqlite')));

        $this->output->title("HOW TO USE DB");

        $insertResult = DB::insert('insert into dogs (name,desc) values ( ?,?)', ['Dayle', 'hello']);
        $dogRows = DB::select("select * from dogs");
        $updateResult = DB::update("update dogs set name = ? where id = ? ", ["newDog", $dogRows[0]->id]);


        DB::transaction(function () {
            DB::table('dogs')->update(['name' => 'oldDog']);
        });

        $dogRows = DB::select("select * from dogs");
        $deleteResult = DB::delete('delete from dogs where id = ?', [$dogRows[0]->id]);
//        $deleteResult = DB::delete('delete from dogs', []);

        dump($insertResult);
        dump($updateResult);
        dump($deleteResult);
        dump($dogRows);


        // 简单创建
        $this->output->title("HOW TO USE EloquentORM");
        $littleDog = new Dog();
        $littleDog->name = "littleDog";
        $littleDog->desc = "i am a little dog";
        $littleDog->save();

        // 批量赋值
        $littleDog = Dog::create([
            'name' => "name",
            'desc' => "desc"
        ]);
        dump($littleDog);

        DB::beginTransaction();
        try {
            // 软删除
            $dogs = Dog::all();
            foreach ($dogs as $dog) {
                $dog->delete();
            }
            dump(count($dogs));
            // 如果此处抛出异常且导致无法执行commit则进入rollback回滚
//            throw new \Exception("");
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }

        // 软删除后不可查询
        $dogs = Dog::all();
        dump("软删除");
        dump(count($dogs));


        // 包含软删除的查找 并 恢复
        $dogs = Dog::withTrashed()->get();
        foreach ($dogs as $dog) {
            $dog->restore();
        }
        dump(count($dogs));


        // 物理删除
        DB::transaction(function () {
            $dogs = Dog::all();
            foreach ($dogs as $dog) {
                $dog->forceDelete();
            }
            dump(count($dogs));
        });

        $dogs = Dog::withTrashed()->get();
        dump(count($dogs));

        $dogs = Dog::onlyTrashed()->get();
        dump(count($dogs));


        return 0;
    }
}
