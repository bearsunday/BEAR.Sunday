<?php

namespace FakeVendor\HelloWorldX\Module;

use BEAR\Resource\SchemeCollectionInterface;
use BEAR\Sunday\Module\SundayModule;
use Ray\Di\AbstractModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind()->annotatedWith('app_name')->toInstance('FakeVendor\HelloWorldX');
        $this->bind(SchemeCollectionInterface::class)->toProvider(SchemeCollectionProvider::class);
        $this->install(new SundayModule);
    }
}
