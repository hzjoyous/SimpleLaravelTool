<?php

namespace App\Console\Commands\Tool;

use App\Utils\SimpleSystem;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use PhpParser\Node\Scalar\MagicConst\Dir;

class windowsPic extends Command
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
        $winPic = DIRECTORY_SEPARATOR . 'Users' . DIRECTORY_SEPARATOR . 'HZJ' . DIRECTORY_SEPARATOR . 'AppData' . DIRECTORY_SEPARATOR . 'Local' . DIRECTORY_SEPARATOR . 'Packages' . DIRECTORY_SEPARATOR . 'Microsoft.Windows.ContentDeliveryManager_cw5n1h2txyewy' . DIRECTORY_SEPARATOR . 'LocalState' . DIRECTORY_SEPARATOR . 'Assets';
        $tmp = DIRECTORY_SEPARATOR . 'Users' . DIRECTORY_SEPARATOR . 'HZJ' . DIRECTORY_SEPARATOR . 'Desktop' . DIRECTORY_SEPARATOR . 'tmp1';

        if (SimpleSystem::getOS() === SimpleSystem::OS_WIN) {
            $rootPath = 'C:';
        } else {
            $rootPath = DIRECTORY_SEPARATOR . 'mnt' . DIRECTORY_SEPARATOR . 'c';
        }

        $winPic = $rootPath . $winPic;
        $tmp = $rootPath . $tmp;

        $fileSystem = new Filesystem();

        foreach ($fileSystem->allFiles($winPic) as $file) {
            $relativePathname = $file->getRelativePathname();
            if ($file->getSize() < 1024 * 10) {
                continue;
            }
            $pathInfo = pathinfo($relativePathname);
            dump($pathInfo);
            if (!$fileSystem->isDirectory($tmp)) {
                $fileSystem->makeDirectory($tmp, 0777, true);
            }
            $fileSystem->copy($winPic . DIRECTORY_SEPARATOR . $relativePathname, $tmp . DIRECTORY_SEPARATOR . $relativePathname . '.jpg');
        }
        return;
    }
}
