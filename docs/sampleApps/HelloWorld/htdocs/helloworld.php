<?php
namespace BEAR\Di;
use BEAR\Framework\FrameworkModule,
    BEAR\App\HelloWorld\Modules\AppModule;

// init
$injector = new Injector(new Container(new Forge(new Config(new Annotation)), new AppModule(new FrameworkModule)));
$resouce = $injector->getInstance('BEAR\Resource\Resource');
$page = $injector->getInstance('BEAR\Framework\HelloWorld\HelloWorld');

// main
try {
    $ro = $resource->request($page)->link('html://self/helloWorld.tpl')->getResourceObject();
    $ro->output('http');
} catch (Exception $e) {
    echo $e;
    exit(1);
}