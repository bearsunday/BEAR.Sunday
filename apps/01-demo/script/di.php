<?php
/**
 * Application Dependency Injettor.
 *
 * @return \Ray\Di\InjectorInterface
 */
namespace BEAR\Application\Script;

use Ray\Di\Annotation,
    Ray\Di\Config,
    Ray\Di\Forge,
    Ray\Di\Container,
    Ray\Di\Injector,
    BEAR\Framework\Module\StandardModule as FrameWorkModule,
    demoWorld\Module\AppModule;

$di = new Injector(new Container(new Forge(new Config(new Annotation))));
$di->setModule(new AppModule(new FrameWorkModule($di)));
return $di;