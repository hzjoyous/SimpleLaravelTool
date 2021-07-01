<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;

class InfiniteClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xdemo:inf';

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
        $arr = [
            ['id' => 2, 'cname' => '分类2', 'parent_id' => 1],
            ['id' => 9, 'cname' => '分类9', 'parent_id' => 8],
            ['id' => 1, 'cname' => '分类1', 'parent_id' => 0],
            ['id' => 7, 'cname' => '分类7', 'parent_id' => 0],
            ['id' => 3, 'cname' => '分类3', 'parent_id' => 2],
            ['id' => 4, 'cname' => '分类4', 'parent_id' => 0],
            ['id' => 6, 'cname' => '分类6', 'parent_id' => 5],
            ['id' => 8, 'cname' => '分类8', 'parent_id' => 7],
            ['id' => 5, 'cname' => '分类5', 'parent_id' => 4],
            ['id' => 10, 'cname' => '分类10', 'parent_id' => 4],
            ['id' => 11, 'cname' => '分类11', 'parent_id' => 4],
            ['id' => 12, 'cname' => '分类12', 'parent_id' => 4],
            ['id' => 13, 'cname' => '分类13', 'parent_id' => 4],
            ['id' => 14, 'cname' => '分类14', 'parent_id' => 4],
            ['id' => 15, 'cname' => '分类15', 'parent_id' => 14],
            ['id' => 16, 'cname' => '分类16', 'parent_id' => 15],
            ['id' => 17, 'cname' => '分类17', 'parent_id' => 16],
            ['id' => 18, 'cname' => '分类18', 'parent_id' => 17],
        ];

        $list = [];

        $buildList = function ($parentId) use ($arr, &$buildList) {
            $list = [];
            foreach ($arr as $item) {
                if ($item['parent_id'] === $parentId) {
                    $son =  $buildList($item['id']);
                    $item['son'] = $son;
                    $list[] = $item;
                }
            }
            return $list;
        };
        $list = $buildList(0);
        dump($list);
        return ;
    }
}
