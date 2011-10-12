<?php
namespace BEAR\Di;
use BEAR\Framework\FrameworkModule,
    BEAR\App\HelloWorld\Modules\AppModule;

// init
$injector = new Injector(new Container(new Forge(new Config(new Annotation)), new AppModule(new FrameworkModule)));
$resouce = $injector->getInstance('BEAR\Resource\Client');
$params = $injector->getInstance('BEAR\Resource\ParamsProvider')->get();

// main
try {
    $ro = $resource->get($params->setUri('page://self/helloWorld'))->link('html://self/helloWorld')->getResourceObject();
    $ro->output('http');
} catch (Exception $e) {
    echo $e;
    exit(1);
}