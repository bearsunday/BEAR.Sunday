<?php

namespace BEAR\Sunday\Provide\Router;

use BEAR\Sunday\Extension\Application\AppInterface;
use BEAR\Sunday\Provide\Application\AppModule;
use BEAR\Sunday\Provide\Application\MinApp;
use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;

class AppModuleTest extends TestCase
{
    public function testApp()
    {
        $app = (new Injector(new AppModule))->getInstance(AppInterface::class);
        $this->assertInstanceOf(MinApp::class, $app);
    }
}
