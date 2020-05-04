<?php

namespace App\Console\Commands;

use App\HttpClient\AipHttpClient;
use Illuminate\Console\Command;
use League\Csv\Reader;
use League\Csv\Statement;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpSpreadsheet\IOFactory as SpreadsheetIOFactory;

class Tmp extends Command
{
    /**
     * redis-cli
     * flushall
     */
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
        $this->t(1);
        return;
    }

    public function t(...$data)
    {
        var_dump($data);
    }
}
