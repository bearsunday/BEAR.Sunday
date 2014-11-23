<?php

use BEAR\Resource\Request;
use BEAR\Sunday\Extension\Application\AppInterface;
use BEAR\Sunday\Provide\Application\AppModule;
use BEAR\Sunday\Extension\Application\AbstractApp;
use Ray\Di\Injector;

$loader = require dirname(__DIR__) . '/vendor/autoload.php';
/** @var $loader \Composer\Autoload\ClassLoader */
$loader->addPsr4('BEAR\Sunday\\', dirname(__DIR__));

$app = (new Injector(new AppModule))->getInstance(AppInterface::class);
/** @var $app AbstractApp */

$request = $app->router->match($GLOBALS);
try {
    // resource request
    $page = $app->resource
        ->{$request->method}
        ->uri($request->path)
        ->withQuery($request->query)
        ->request();
    /** @var $page Request */

    // representation transfer
    $page()->transfer($app->responder);

} catch (\Exception $e) {
    $code = $e->getCode() ?: 500;
    http_response_code($code);
    echo $code;
    error_log($e);
}
