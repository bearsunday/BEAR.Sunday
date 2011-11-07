<?php

/**
 * HelloWorld without bootstrap script.
 */
namespace BEAR\App\HelloWorld;

use BEAR\Framework\FrameworkModule,
    BEAR\App\HelloWorld\Modules\AppModule,
    Ray\Di\Injector,
    Ray\Di\Container ,
    Ray\Di\Forge,
    Ray\Di\Config,
    Ray\Di\Annotation;

// di
$di = new Injector(new Container(new Forge(new Config(new Annotation()), new AppModule(new FrameworkModule)));
$resource = $di->getInstance('BEAR\Resource\Resource');

try {
    $page = $resource->newInstance('page://self/helloWorld');
    $resource->object($page)->link('html')->link('http')->get();
} catch (Exception $e) {
    echo $e;
    exit(1);
} 