<?php

ini_set('memory_limit', -1);
define('LARAVEL_START', microtime(true));

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use React\EventLoop\Factory;
use React\Http\Message\Response;
use React\Http\Message\ServerRequest;
use React\Http\Server;
use Symfony\Component\HttpFoundation\Request as SRequest;

require __DIR__ . '/vendor/autoload.php';

/* @var $app Application */
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->loadEnvironmentFrom(__DIR__.'/.env');
/* @var $kernel Kernel */
$kernel = $app->make(Kernel::class);

$loop = Factory::create();

$server = new Server($loop, function (ServerRequest $request) use ($kernel) {
    SRequest::enableHttpMethodParameterOverride();
    $laravelRequest  = Request::createFromBase(SRequest::create(
        (string)$request->getUri(),
        $request->getMethod(),
        $request->getQueryParams(),
        $request->getCookieParams(),
        $request->getUploadedFiles(),
        $request->getServerParams(),
        $request->getBody()));
    $laravelResponse = $kernel->handle(
        $laravelRequest
    );

    return new Response(
        $laravelResponse->getStatusCode(),
        $laravelResponse->headers->allPreserveCaseWithoutCookies(),
        $laravelResponse->getContent()
    );
});

$socket = new React\Socket\Server(8080, $loop);
$server->listen($socket);

$loop->run();
