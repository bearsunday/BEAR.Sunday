<?php
/**
 * Module
 *
 * @package    helloWorld
 * @subpackage Module
 */
namespace helloWorld\Module;

use Ray\Di\AbstractModule,
    Ray\Di\InjectorInterface;

/**
 * Application module
 *
 * @package    helloWorld
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
        $this->bind()->annotatedWith('AppName')->toInstance('helloWorld');
        $this->bind('BEAR\Resource\SchemeCollection')->toProvider('\helloWorld\Module\SchemeCollectionProvider');
    }
}