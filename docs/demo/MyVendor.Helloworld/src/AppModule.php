<?php

namespace MyVendor\HelloWorld;

use BEAR\Resource\Annotation\AppName;
use BEAR\Sunday\Extension\Application\AppInterface;
use BEAR\Sunday\Module\SundayModule;
use MyVendor\HelloWorld\Resource\Page\Index;
use Ray\Di\AbstractModule;

class AppModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind()->annotatedWith(AppName::class)->toInstance(__NAMESPACE__);
        $this->bind(AppInterface::class)->to(App::class);
        $this->install(new SundayModule);
    }
}
