<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;
use InvalidArgumentException;
use Symfony\Component\DomCrawler\Crawler;

class XPath extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zdemo:xPath
    {mode=0 :运行模式}';

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
        $mode = $this->argument('mode');

        $html = <<<'HTML'
<!DOCTYPE html>
<html>
    <body>
        <p class="message">Hello World!</p>
        <p>Hello Crawler!</p>
    </body>
</html>
HTML;

        if ($mode === '1') {
            $html  = file_get_contents(__DIR__ . '/tmp/0.html');
        }

        $crawler = new Crawler($html);

        $result = $crawler
            // ->filter('div[class="group-list"]')
            ->filter('div[class="info"]')
            ->each(function (Crawler $crawler, $i) {

                try {
                    $crawler->filter('div[class="title"]')->text();
                    $crawler->filter('a')->attr('href');
                } catch (InvalidArgumentException $e) {
                    return [];
                }
                return [
                    'title' => $crawler->filter('div[class="title"]')->text(),
                    'id' => explode('/', $crawler->filter('a')->attr('href'))[4],
                    'num' => trim($crawler->filter('span[class="num"]')->text(), "()")
                ];
            });

        uasort($result, function ($x, $y) {
            // $x['num'] ??= 10000;
            // $y['num'] ??= 10000;
            return $x['num'] <=> $y['num'];
        });
        $result = array_values($result);
        echo json_encode($result, JSON_UNESCAPED_UNICODE);


        return;
    }
}
