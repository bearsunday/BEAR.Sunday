<?php

namespace BEAR\Sunday\Provide\Application;


use Ray\Di\AbstractModule;
use BEAR\Sunday\Extension\Application\AppInterface;

class AppModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(AppInterface::class)->to(DemoApp::class);
    }
}
