<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class LaravelHelper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zdemo:laravel';

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

        $this->info(Str::limit('The quick brown fox jumps over the lazy dog', 20));
        $this->info(Str::limit('The quick brown fox jumps over the lazy dog', 20, '[...]'));
        $this->info(Str::between('My name is Inigo Montoya.', 'My name is ', '.'));

        dump(head([1, 2, 3, 4]));
        dump(last([1, 2, 3, 4]));

        $this->info("blank");
        dump(blank(''));
        dump(blank('   '));
        dump(blank(null));
        dump(blank(collect()));
        dump(blank(true));
        dump(blank(false));
        dump(blank(0));

        $this->info("Str::contains");
        dump($contains = Str::contains('My name is Inigo Montoya.', 'Inigo'));
        dump($contains = Str::contains('My name is Inigo Montoya.', 'Andrew'));


        return;
    }
}
