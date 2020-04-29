<?php

namespace App\Console\Commands\Tool;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use PhpOffice\PhpWord\Element\Cell;
use PhpOffice\PhpWord\Element\Row;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\Element\Text;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class Word extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:word';

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
        $source = __DIR__ . '/2018级畜牧兽医（益生）班.docx';
        $data = [];
        $dirPath = "C:\Users\HZJ\Desktop\双创教育培训学生基本信息汇总表-动物科技系";
        $fileSystem = new Filesystem();
        foreach ($fileSystem->allFiles($dirPath) as $file) {
            echo $file->getPathname();
            $phpWord = IOFactory::load($file->getPathname());
            $newData = $this->getTableAsArr($phpWord);
            array_shift($newData);
            $data = array_merge($newData,$data);
        }
        dump($data);
        return;
    }

    private function getTableAsArr(PhpWord $phpWord)
    {
        $data = [];
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $ele) {
                if ($ele instanceof Table) {
                    foreach ($ele->getRows() as $row) {
                        if ($row instanceof Row) {
                            $data[] = array_map(function (Cell $item) {
                                $testRun = $item->getElement(0);
                                if ($testRun instanceof TextRun) {
                                    $text = $testRun->getElement(0);
                                    if ($text instanceof Text)
                                        return $text->getText();

                                }
                                return '';
                            }, $row->getCells());

                        }

                    }
                }
            }
        }
        return $data;
    }
}
