<?php

namespace App\Console\Commands\Y;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

class T200506 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'y:205006';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'md 批量处理';

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
        $startPath = 'C:\Users\HZJ\Desktop\phpmd';
        $f = new Finder();
        $f->files()->in($startPath);
        foreach ($f as $file) {
            $absoluteFilePath = $file->getRealPath();
            $fileNameWithExtension = $file->getRelativePathname();
            $contents = $file->getContents();
            $name = basename($fileNameWithExtension, '.md');
            $time = trim(explode('-',$fileNameWithExtension)[0],'PH');
            $headerStr = <<<eof
---
title: PHP[OOP入门]{$name}
date: 2017-01-01 01:02:{$time}
tags:
- php
categories: php
---


eof;;

//            dd($absoluteFilePath,
//                $fileNameWithExtension,
//                $headerStr);
            file_put_contents(__DIR__ . '/tmp/' . $fileNameWithExtension, $headerStr . $contents);
        }
        return;

    }
}
