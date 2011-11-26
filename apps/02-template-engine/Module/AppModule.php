<?php

namespace template\Module;

use Ray\Di\AbstractModule,
    Ray\Di\InjectorInterface;

/**
 * Application default module
 */
class AppModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind()->annotatedWith('ResourceAdapters')->toProvider('\template\Module\ResourceAdaptersProvider');
        $this->bind()->annotatedWith('Twig')->toProvider('\template\Module\TwigProvider');
        $this->bind()->annotatedWith('Smarty')->toProvider('\template\Module\SmartyProvider');
    }

}