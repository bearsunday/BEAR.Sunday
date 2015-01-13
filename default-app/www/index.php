<?php

use BEAR\Sunday\Extension\Application\AppInterface;
use BEAR\Sunday\Module\SundayModule;
use Ray\Di\Injector;

$loader = require dirname(dirname(__DIR__)) . '/vendor/autoload.php';
/** @var $loader \Composer\Autoload\ClassLoader */
$loader->addPsr4('BEAR\Sunday\\', dirname(__DIR__));

$app = (new Injector(new SundayModule))->getInstance(AppInterface::class);
/** @var $app \BEAR\Sunday\Extension\Application\AbstractApp */
$request = $app->router->match($GLOBALS, $_SERVER);

try {
    // resource request
    $page = $app->resource
        ->{$request->method}
        ->uri($request->path)
        ->withQuery($request->query)
        ->request();
    /** @var $page \BEAR\Resource\Request */

    // representation transfer
    $page()->transfer($app->responder, $_SERVER);
    exit(0);
} catch (\Exception $e) {
    $errorPage = $app->error->handle($e, $request);
    $errorPage->transfer($app->responder);
    exit(1);
}
