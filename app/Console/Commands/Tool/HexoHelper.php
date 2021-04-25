<?php

namespace App\Console\Commands\Tool;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class HexoHelper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:h:helper';

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
        $f = new Finder();
        $f->files()->in('D:\WorkSpace\simple\simpleHexoBlog\source\_posts');
        $books = [];
        foreach ($f as $file) {
            $absoluteFilePath = $file->getRealPath();
            $fileNameWithExtension = $file->getRelativePathname();
            $contents = $file->getContents();

            preg_match('/---[\s\S]*?---/', $contents, $match);
            $header = $match[0] ?? '';

            $header = str_replace(
                ['---',],
                ['',],
                $header
            );
            $header = Yaml::parse($header);
            if (is_string($header['categories'] ?? [])) {
                $header['categories'] = [$header['categories']];
            }
            if (is_string($header['tags'] ?? [])) {
                $header['tags'] = [$header['tags']];
            }
//            $header['categories'] = array_merge($header['categories'] ?? [], $header['tags'] ?? []);
            echo $header['date'];
            if ($header['date'] ?? false) {
                $header['date'] = !is_numeric($header['date']) ? strtotime($header['date']) : $header['date'];
                $header['date'] = date("Y-m-d\TH:i:sP", $header['date']);
            }
//'tags'
            $allowed = [];
            $filtered = array_filter(
                $header,
                function ($key) use ($allowed) {
                    return !in_array($key, $allowed);
                },
                ARRAY_FILTER_USE_KEY
            );
            echo storage_path($fileNameWithExtension) . PHP_EOL;
            $contents = preg_replace('/---[\s\S]*?---/', '', $contents, 1);
            $headerYaml = Yaml::dump($filtered);
            $aContent = <<<eof
---
$headerYaml
---

$contents
eof;
            $dir = dirname(storage_path('\\post\\' . $fileNameWithExtension));

            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            file_put_contents(storage_path('\\post\\' . $fileNameWithExtension), $aContent);

//            dd($aContent);
//            echo

            $books[] = $header;

            //dump($absoluteFilePath, $fileNameWithExtension, $header);
        }
        dd($books);
        $this->table([
            'title',
            'date',
            'tags',
            'categories',
            'p',
        ], $books);
        return;
    }

    function oldFunction()
    {

//            $header = str_replace(
//                ['---', "\r\n", "\r", "\n", "\n\r"],
//                ['', ',', ',', ','],
//                $header
//            );
//            $header = array_reduce(explode(',', $header), function ($pre, $item) use ($fileNameWithExtension) {
//                $data = $item;
//                if ($item) {
//                    $item = explode(':', $item, 2);
//                    if (count($item) === 2) {
//                        $pre[$item[0]] = $item[1];
//                        /*if ($item[0] === 'title') {
//                            dump($item[1]);
//                        }*/
//                    } else {
//                        dump($fileNameWithExtension .' has '. $data);
//                    }
//
//                }
//                return $pre;
//            }, [
//                'title'      => '',
//                'date'       => '',
//                'tags'       => '',
//                'categories' => '',
//                'p'          => '',
//            ]);
    }
}
