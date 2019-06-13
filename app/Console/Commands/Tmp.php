<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;

class Tmp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:tmp';

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

        $token = (new Builder())->setIssuer('http://example.com') // Configures the issuer (iss claim)
        ->setAudience('http://example.org') // Configures the audience (aud claim)
        ->setId('4f1g23a12aa', true) // Configures the id (jti claim), replicating as a header item
        ->setIssuedAt(time()) // Configures the time that the token was issued (iat claim)
        ->setNotBefore(time() + 60) // Configures the time that the token can be used (nbf claim)
        ->setExpiration(time() + 3600) // Configures the expiration time of the token (exp claim)
        ->set('uid', 1) // Configures a new claim, called "uid"
        ->getToken(); // Retrieves the generated token


        $token->getHeaders(); // Retrieves the token headers
        $token->getClaims(); // Retrieves the token claims

        echo $token->getHeader('jti').PHP_EOL; // will print "4f1g23a12aa"
        echo $token->getClaim('iss').PHP_EOL; // will print "http://example.com"
        echo $token->getClaim('uid').PHP_EOL; // will print "1"
        echo $token.PHP_EOL; // The string representation of the object is a JWT string (pretty easy, right?)
        $str = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIiwianRpIjoiNGYxZzIzYTEyYWEifQ.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLmNvbSIsImF1ZCI6Imh0dHA6XC9cL2V4YW1wbGUub3JnIiwianRpIjoiNGYxZzIzYTEyYWEiLCJpYXQiOjE1NTYwMjMxMTksIm5iZiI6MTU1NjAyMzE3OSwiZXhwIjoxNTU2MDI2NzE5LCJ1aWQiOjF9.';
        $token = (new Parser())->parse((string) $token); // Parses from a string
        $token->getHeaders(); // Retrieves the token header
        $token->getClaims(); // Retrieves the token claims

        echo $token->getHeader('jti').PHP_EOL; // will print "4f1g23a12aa"
        echo $token->getClaim('iss').PHP_EOL; // will print "http://example.com"
        echo $token->getClaim('uid').PHP_EOL; // will print "1"
        return ;
    }
}
