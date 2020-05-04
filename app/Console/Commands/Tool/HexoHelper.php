<?php

namespace App\Console\Commands\Tool;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

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
        $f->files()->in(__DIR__ . '/../../../../../hzj/hexo/source/_posts');
        $books = [];
        foreach ($f as $file) {
            $absoluteFilePath      = $file->getRealPath();
            $fileNameWithExtension = $file->getRelativePathname();
            $contents              = $file->getContents();

            preg_match('/---[\s\S]*?---/', $contents, $match);
            $header = $match[0] ?? '';
            $header = str_replace(
                ['---', "\r\n", "\r", "\n", "\n\r"],
                ['', ',', ',', ','],
                $header
            );
            $header = array_reduce(explode(',', $header), function ($pre, $item) use ($fileNameWithExtension) {
                $data = $item;
                if ($item) {
                    $item = explode(':', $item, 2);
                    if (count($item) === 2) {
                        $pre[$item[0]] = $item[1];
                        /*if ($item[0] === 'title') {
                            dump($item[1]);
                        }*/
                    } else {
                        dump($fileNameWithExtension .' has '. $data);
                    }

                }
                return $pre;
            }, [
                'title'      => '',
                'date'       => '',
                'tags'       => '',
                'categories' => '',
                'p'          => '',
            ]);

            $books[] = $header;

            //dump($absoluteFilePath, $fileNameWithExtension, $header);
        }
        $this->table([
            'title',
            'date',
            'tags',
            'categories',
            'p',
        ], $books);
        //dump($books);
        return;
    }
}
