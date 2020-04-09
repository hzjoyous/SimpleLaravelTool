<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;

class Demo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:demo {user : The ID of the user} {--queue= :Whether the job should be queued}';

    /**
     * email:send {user} {--Q|queue}
     * email:send {user} {--queue=default}
     * php artisan email:send 1 --queue=default
     * 
     * email:send {user*}
     * php artisan email:send foo bar
     * 
     * email:send {user} {--id=*}
     * php artisan email:send --id=1 --id=2
     */

    /**
     * The console command description.
     * php artisan email:send 1 --queue=default
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


        $userId = $this->argument('user');

        if ($userId) {
            $this->info(sprintf('You passed an argument: %s', $userId));
        }

        $this->output->title('这是使用 title 输出的');

        $this->info('这是使用 info 输出的');

        $this->comment('这是使用 comment 输出的');

        $this->output->caution('这是使用 caution 输出的');

        $this->output->block('这是 block 输出的');

        $this->line('这是使用 writeln 输出的');

        $this->output->text('这是 text 输出的');

        $this->output->newLine(5);

        $raws = [
            ['BiuBiuBiu', '30'],
            ['BiuBiuBiu', '30'],
            ['BiuBiuBiu', '30'],
            ['BiuBiuBiuBoomBoomBoom', '30'],
        ];

        $this->table(['name', 'age'], $raws);

        $this->error('这是 error');

        $this->output->warning('这是 waring');

        $this->output->success('这是 success');


        $confirmResult = $this->confirm('这是 confirm question ');

        $this->info($confirmResult);

        $askQuestionResult = $this->ask('What is your name?');

        $this->info($askQuestionResult);

        $password = $this->secret('What is the password?');


        if ($this->confirm('Do you wish to continue?')) {
            echo 1;
        }

        $name = $this->anticipate('What is your name?', ['Taylor', 'Dayle']);

        $name = $this->choice('What is your name?', ['Taylor', 'Dayle'], 'Dayle');

        $this->info('Display this on the screen');

        $i           = 0;
        $progressMax = 100;
        $bar         = $this->output->createProgressBar($progressMax);
        while ($i++ < $progressMax) {
            usleep(300);
            $bar->advance();
        }

        $bar->finish();

        $this->output->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
