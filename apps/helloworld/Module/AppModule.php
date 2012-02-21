<?php
/**
 * Module
 *
 * @package    helloworld
 * @subpackage Module
 */
namespace helloworld\Module;

use Ray\Di\Scope;

use BEAR\Framework\Module\StandardModule;
use Ray\Di\AbstractModule,
    Ray\Di\InjectorInterface,
    Ray\Di\Annotation,
    Ray\Di\Config,
    Ray\Di\Forge,
    Ray\Di\Container,
    Ray\Di\Injector,
    Ray\Di\Definition;

/**
 * Application module
 *
 * @package    helloworld
 * @subpackage Module
 */
class AppModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('BEAR\Resource\SchemeCollection')->toProvider('\helloworld\Module\SchemeCollectionProvider')->in(Scope::SINGLETON);
    }
}