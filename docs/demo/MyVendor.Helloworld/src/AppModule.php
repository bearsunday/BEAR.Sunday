<?php

namespace MyVendor\HelloWorld;

use BEAR\Sunday\Extension\Application\AppInterface;
use BEAR\Sunday\Module\SundayModule;
use Ray\Di\AbstractModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind()->annotatedWith('app_name')->toInstance(__NAMESPACE__);
        $this->bind(AppInterface::class)->to(App::class);
        $this->install(new SundayModule);
    }
}
