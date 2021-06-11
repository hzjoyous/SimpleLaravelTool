<?php

namespace App\Console\Commands\Tool;

use Illuminate\Console\Command;
use PhpParser\Error;
use PhpParser\NodeDumper;
use PhpParser\Parser\Multiple;
use PhpParser\ParserFactory;

class PHPParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:parser';

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
     */
    public function handle(): int
    {

        $code = <<<'CODE'
<?php

function test($foo)
{
    var_dump($foo);
}

class Cat
{
    public int $a = 1;
    protected float $b = 2;
    public function __construct($a) {
        $this->a = $a;
    }
}
$cat = new Cat(1);
$f = function () use ($cat){
    echo $cat;
};
CODE;

        /**
         * 创建一个php7的语法解析器（Parser），在没有传入词法解析器（Lexer）的时候会创建一个默认的词法分析器
         * 同时如果没有指定只使用php7的语法解析器，那么将会同时创建一个php7和一个php5的parser
         */
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);

        try {
            /* @var $parser Multiple */
            $ast = $parser->parse($code);
            /**
             * 解析时先使用[0]解析器，当解析存在报错时，会调用后续的解析器，直至等到一个完全没有解析错误的结果
             *
             * 上面的都不重要
             *
             */
        } catch (Error $error) {
            echo "Parse error: {$error->getMessage()}\n";
            return 1;
        }

        $dumper = new NodeDumper;
        echo $dumper->dump($ast) . "\n";

        return 0;
    }
}
