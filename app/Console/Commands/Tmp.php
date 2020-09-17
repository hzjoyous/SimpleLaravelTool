<?php

namespace App\Console\Commands;

use App\Models\Dog;
use App\Models\DouBanComment;
use App\Models\DouBanTopic;
use App\Utils\SimpleSystem;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Tmp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string $signature
     */
    protected $signature = 'z:z';

    /**
     * The console command description.
     *
     * @var string $description
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
        $userId = config('simple.douban.s.userId');
        $this->line($userId);
        $topics = DouBanTopic::where('user_id', $userId)->get();
        $comments = DouBanComment::where('user_id', $userId)->get();
        foreach ($topics as $topic) {
            $topicUrl = "https://www.douban.com/group/topic/{$topic->topic_id}/?start=0";
            $this->line($topic->topic_title);
            $this->line($topicUrl);
            if (false && SimpleSystem::isWin()) {
                exec("start $topicUrl");
            }
        }
        foreach ($comments as $comment) {
            $topicUrl = "https://www.douban.com/group/topic/{$comment->topic_id}/?start=0";
            $this->line($comment->comment);
            $this->line($topicUrl);
            $this->line($comment->insert_at);
            if (false && SimpleSystem::isWin()) {
                exec("start $topicUrl");
            }
        }
        $dogs = Dog::all();
        foreach ($dogs as $dog) {
            $dog->forceDelete();
        }
        //Faker\Provider\UserAgent
        $faker = Factory::create();
        dump($faker->userAgent,
            $faker->chrome,
            $faker->firefox,
            $faker->safari,
            $faker->opera,
            $faker->internetExplorer,
            '#',
            $faker->userAgent);


        // 20/8
        // 400w 8w
        return;
    }

    public function t(...$data)
    {
        dump($data);
        $a = true || $a = false;
        dump($a);
        $arr = array_unique([]);
        dump($arr);
        $result = DB::insert("INSERT INTO dogs ( name, desc, created_at, updated_at) VALUES ( 'name', 'desc', '2020-09-17 20:50:58', '2020-09-17 20:50:58')");
        dump(DB::select("select count(id) from dogs"));
    }
}
