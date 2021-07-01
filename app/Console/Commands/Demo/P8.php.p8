<?php

namespace App\Console\Commands\Demo;

use Exception;
use Illuminate\Console\Command;

class P8 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xdemo:p8';

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
     * @return int
     * @throws Exception
     */
    public function handle(): int
    {
        $this->info("how to use match");
        $state  = 'pay';
        $result = match ($state) {
            'pay' => '支付',
            'waitPay' => '待支付',
            default => '未知'
        };

        dump($result);

        $age = 23;

        $result = match (true) {
            $age >= 65 => 'senior',
            $age >= 25 => 'adult',
            $age >= 18 => 'young adult',
            default => 'kid',
        };

        dump($result);
        dump($this->isLeap(1900));
        dump($this->isLeap(2000));
        dump($this->isLeap(2001));
        dump($this->isLeap(1994));
        dump($this->isLeap(1996));

        $kv = [
            1 => 1,
            2 => 2,
        ];

        $result = $kv[1] ?? throw new Exception();

        dump($result);
        $this->info("params");
        dump($this->fParams(b: 'B'));
        $repository = $this->getRepository();
        $result     = $repository?->getUser(5)?->name;
        dump($result);

        $this->info('p8 增加了一个新的类，只不过这个类在其不被引入的情况下也可以自行实现,其接口已经很早就加入了php');

        $wm = new \WeakMap();

        dump($wm);

        $this->pMixedPrams('dsa');
        $this->pTypePrams('asd');
        var_dump($this->fibonacciTailCall(10,0,1));

        var_dump($this->fibonacci(10));


        return 0;
    }

    public function fibonacci($n): int
    {
        if ($n === 0) {
            return 0;
        }
        if ($n === 1) {
            return 1;
        }
        return $this->fibonacci($n - 1) + $this->fibonacci($n - 2);
    }

    public function fibonacciTailCall($n, $result, $preValue) {
        if ($n == 0) {
            return $result;
        }
        return $this->fibonacciTailCall($n - 1, $preValue, $result + $preValue);
    }


    protected function getRepository(): mixed
    {
        return null;
    }

    public function pTypePrams(string|int|bool|null|float|object|callable|iterable $p)
    {
        var_dump($p);
    }

    public function pMixedPrams(mixed $p)
    {
        var_dump($p);
    }

    public function fParams(string $a = 'a', string $b = 'b', string $c = 'c'): string
    {
        return $a . $b . $c;
    }

    /**
     * @throws Exception
     */
    public function daysInMonth(string $month, int $year = 1999): int
    {
        return match (strtolower(substr($month, 0, 3))) {
            'jan', 'mar', 'may', 'jul', 'aug', 'oct', 'dec' => 31,
            'feb' => $this->isLeap($year) ? 29 : 28,
            'apr', 'jun', 'sep', 'nov' => 30,
            default => throw new Exception("Bogus month"),
        };
    }

    public function isLeap(int $year): bool
    {
        return match (true) {
            $year % 100 !== 0 && $year % 4 === 0, $year % 400 == 0 => true,
            default => false,
        };
    }

    public function isLeapUseIf(int $year):bool
    {
        if ($year % 100 !== 0 && $year % 4 === 0 || $year % 400 == 0) {
            return true;
        } else {
            return false;
        }
    }


}
