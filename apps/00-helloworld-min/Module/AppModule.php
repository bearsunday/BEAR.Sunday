<?php

namespace helloWorld\Module;

use Ray\Di\AbstractModule,
    Ray\Di\InjectorInterface;

/**
 * Application default module
 */
class AppModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind()->annotatedWith('ResourceAdapters')->toProvider('\helloWorld\Module\ResourceAdapterProvider');
    }
}