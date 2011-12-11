<?php
/**
 * Return application dependency injector.
 *
 * @package    hellowolrd
 * @subpackage script
 *
 * @return  Ray\Di\InjectorInterface
 */
use Ray\Di\Annotation,
    Ray\Di\Config,
    Ray\Di\Forge,
    Ray\Di\Container,
    Ray\Di\Injector;
use BEAR\Framework\Module\StandardModule as FrameWorkModule;
use helloWorld\Module\AppModule;

$di = new Injector(new Container(new Forge(new Config(new Annotation))));
$di->setModule(new AppModule(new FrameWorkModule($di)));
return $di;