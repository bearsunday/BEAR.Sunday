<?php

/**
 * HelloWorld without bootstrap script.
 */
namespace BEAR\Di;
use BEAR\Framework\FrameworkModule,
    BEAR\App\HelloWorld\Modules\AppModule,
    Ray\Di\Injector,
    Ray\Di\Container ,
    Ray\Di\Forge,
    Ray\Di\Config,
    Ray\Di\Annotation;

// di
$di = new Injector(new Container(new Forge(new Config(new Annotation)), new AppModule(new FrameworkModule)));
$resource = $di->getInstance('BEAR\Resource\Resource');

try {
    $page = $resource->newInstance('page://self/helloWorld');
    $resource->get($page)->link('html')->link('http');
} catch (Exception $e) {
    echo $e;
    exit(1);
} 