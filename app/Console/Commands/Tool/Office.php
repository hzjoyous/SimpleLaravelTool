<?php

namespace App\Console\Commands\Tool;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Office extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:office';

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
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function handle()
    {

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');

        $tmpPath       = storage_path('tmp');
        $inputFileName = $tmpPath . '/ceshi.xls';

        /** Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);

        var_dump($spreadsheet);

        $this->output->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return;
    }
}
