<?php

use Ray\Di\Annotation,
    Ray\Di\Config,
    Ray\Di\Forge,
    Ray\Di\Container,
    Ray\Di\Injector,
    BEAR\Framework\Module\StandardModule as FrameWorkModule,
    helloWorld\Module\AppModule;

$di = new Injector(new Container(new Forge(new Config(new Annotation))));
$module = new AppModule(new FrameWorkModule($di));
$di->setModule($module);

return $di;