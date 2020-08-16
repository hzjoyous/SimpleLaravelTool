<?php

namespace App\Console\Commands\Tool\Study;

use Illuminate\Console\Command;

class English extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:eng';

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
        $file = fopen(__DIR__ . '/TOEFL_2.json', "r");
        $wordData = [];
        $i = 0;
        while (!feof($file)) {
            $EnglishWordString = fgets($file);//fgets()函数从文件指针中读取一行
            $EnglishWordArr = json_decode($EnglishWordString, true);
            $wordHead = $EnglishWordArr['content']['word']['wordHead'] ?? null;
            if (!$wordHead) {
                break;
            }
            $wordData[strtolower($EnglishWordArr['content']['word']['wordHead'])] = array_map(function ($item) {
                return $item['tran'];
            }, $EnglishWordArr['content']['word']['content']['syno']['synos'] ?? []);
            $i++;
        }
        fclose($file);
        $engStrStart = file_get_contents(__DIR__ . '/eng.txt');
        $engStr = str_replace("\n", ' ', $engStrStart);
        $wordArr = explode(' ', $engStr);
        $showWord = [];
        array_map(function ($item) use (&$showWord, $wordData) {
            $waitShowWord = strtolower(rtrim($item, '. \t\n\r\0\x0B,"'));
            if (array_key_exists($waitShowWord, $wordData)) {
                $showWord[$waitShowWord] = $wordData[$waitShowWord];
            }
            return $showWord;
        }, $wordArr);
        echo $engStrStart;
        foreach ($showWord as $word => $value) {
            echo "$word:" . implode(';', $value) . PHP_EOL;
        }
        return;
    }
}
