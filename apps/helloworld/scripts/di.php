<?php
namespace helloworld;

use BEAR\Framework\Module\StandardModule;

use Ray\Di\Annotation,
    Ray\Di\Config,
    Ray\Di\Forge,
    Ray\Di\Container,
    Ray\Di\Injector,
    Ray\Di\Definition;

/**
 * Return application dependency injector.
 *
 * @package    helloworld
 * @subpackage script
 *
 * @return  Ray\Di\InjectorInterface
 */
$di = new Injector(new Container(new Forge(new Config(new Annotation(new Definition)))));
$di->setModule(new Module\AppModule(new StandardModule($di, __NAMESPACE__)));
return $di;