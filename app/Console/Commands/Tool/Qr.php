<?php

namespace App\Console\Commands\Tool;

use Endroid\QrCode\QrCode;
use Illuminate\Console\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class Qr extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:qr';

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
        $style = new OutputFormatterStyle('black', 'black', ['bold']);
        $this->output->getFormatter()->setStyle('blackc', $style);
        $style = new OutputFormatterStyle('white', 'white', ['bold']);
        $this->output->getFormatter()->setStyle('whitec', $style);

        $qrCode = new QrCode();

        while (
            ($str = $this->ask('输入想要转化的字符串(直接回车退出)', null))
            &&
            ($str !== null)
        ) {

            $qrCode->setText($str);

            $data   = $qrCode->getData();
            $matrix = $data['matrix'] ?? [];
            $length = $data['block_count'];

            $isWin    = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
            $pxMap[0] = $isWin ? '<whitec>mm</whitec>' : '<whitec>  </whitec>';
            $pxMap[1] = '<blackc>  </blackc>';

            $this->output->newLine();
            for ($i = 0; $i < $length + 1; $i++) {
                $this->output->write($pxMap[0]);
            }
            $this->output->writeln($pxMap[0]);
            foreach ($matrix as $line) {
                $this->output->write($pxMap[0]);
                foreach ($line as $value) {
                    $this->output->write($pxMap[$value]);
                }
                $this->output->writeln($pxMap[0]);
            }
            for ($i = 0; $i < $length + 1; $i++) {
                $this->output->write($pxMap[0]);
            }
            $this->output->writeln($pxMap[0]);
        }

        $this->output->success('bye~');
        return;
    }
}
