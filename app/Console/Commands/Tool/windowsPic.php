<?php

namespace App\Console\Commands\Tool;

use App\Utils\SimpleSystem;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class WindowsPic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:winPic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'windows锁屏壁纸提取';

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
        if (SimpleSystem::getOS() !== SimpleSystem::OS_WIN) {
            $this->error('当前系统非windows，执行终止');
            return;
        }
        $winPic = 'C:\Users\HZJ\AppData\Local\Packages\Microsoft.Windows.ContentDeliveryManager_cw5n1h2txyewy\LocalState\Assets';
        $tmp = 'C:\Users\HZJ\Desktop\tmp1';
        $fileSystem = new Filesystem();

        foreach ($fileSystem->allFiles($winPic) as $file) {
            $relativePathname = $file->getRelativePathname();
            if ($file->getSize() < 1024 * 10) {
                continue;
            }
            dump($file);
            $pathInfo         = pathinfo($relativePathname);
            dump($relativePathname);
            if (!$fileSystem->isDirectory($tmp)) {
                $fileSystem->makeDirectory($tmp, 0777, true);
            }
            $fileSystem->copy($winPic . DIRECTORY_SEPARATOR . $relativePathname, $tmp . DIRECTORY_SEPARATOR . $relativePathname . '.jpg');
        }
    }
}
