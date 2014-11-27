<?php

namespace FakeVendor\HelloWorld\Module;

use BEAR\Sunday\Module\SundayModule;
use Ray\Di\AbstractModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind()->annotatedWith('app_name')->toInstance('FakeVendor\HelloWorld');
        $this->install(new SundayModule);
    }
}
