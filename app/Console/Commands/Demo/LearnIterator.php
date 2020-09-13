<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;
use Iterator;

class LearnIterator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zdemo:iterator';

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
        $number = new class(5) implements Iterator {
            protected $i = 1;
            protected $key;
            protected $val;
            protected $count;

            public function __construct(int $count)
            {
                $this->count = $count;
                echo "第{$this->i}步:对象初始化.\n";
                $this->i++;
            }

            public function rewind()
            {
                $this->key = 0;
                $this->val = 0;
                echo "第{$this->i}步:rewind()被调用.\n";
                $this->i++;
            }

            public function next()
            {
                $this->key += 1;
                $this->val += 2;
                echo "第{$this->i}步:next()被调用.\n";
                $this->i++;
            }

            public function current()
            {
                echo "第{$this->i}步:current()被调用.\n";
                $this->i++;
                return $this->val;
            }

            public function key()
            {
                echo "第{$this->i}步:key()被调用.\n";
                $this->i++;
                return $this->key;
            }

            public function valid()
            {
                echo "第{$this->i}步:valid()被调用.\n";
                $this->i++;
                return $this->key < $this->count;
            }
        };

        echo "start...\n";
        foreach ($number as $key => $value) {
            echo "{$key} - {$value}\n";
        }
        echo "...end...\n";


        return 0;
    }
}


