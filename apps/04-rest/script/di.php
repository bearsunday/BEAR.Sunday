<?php
/**
 * Return application dependency injettor.
 *
 * @return \Ray\Di\InjectorInterface
 */

use Ray\Di\Annotation,
    Ray\Di\Config,
    Ray\Di\Forge,
    Ray\Di\Container,
    Ray\Di\Injector,
    BEAR\Framework\Module\StandardModule as FrameWorkModule,
    restWorld\Module\AppModule;

$di = new Injector(new Container(new Forge(new Config(new Annotation))));
$di->setModule(new AppModule(new FrameWorkModule($di)));
return $di;