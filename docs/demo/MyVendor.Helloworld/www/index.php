<?php

use BEAR\Resource\Request;
use BEAR\Sunday\Extension\Application\AbstractApp;
use BEAR\Sunday\Extension\Application\AppInterface;
use Composer\Autoload\ClassLoader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use MyVendor\HelloWorld\AppModule;
use Ray\Di\Injector;

/* @var $loader ClassLoader*/
$loader = require dirname(__DIR__) . '/vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

$app = (new Injector(new AppModule))->getInstance(AppInterface::class);
/* @var $app AbstractApp */

$request = $app->router->match($GLOBALS, $_SERVER);
try {
    // resource request
    $page = $app->resource
        ->{$request->method}
        ->uri($request->path)
        ->withQuery($request->query)
        ->request();
    /* @var $page Request */

    // representation transfer
    $page()->transfer($app->responder, $_SERVER);
} catch (\Exception $e) {
    error_log($e);
}
