<?php

namespace BEAR\Sunday\Provide\Router;

use Ray\Di\Injector;
use BEAR\Sunday\Provide\Application\AppModule;
use BEAR\Sunday\Extension\Application\AppInterface;
use BEAR\Sunday\Provide\Application\MinApp;

class AppModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testApp()
    {
        $app = (new Injector(new AppModule))->getInstance(AppInterface::class);
        $this->assertInstanceOf(MinApp::class, $app);
    }
}
