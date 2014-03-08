<?php

namespace BEAR\Sunday\Module\Framework;

use BEAR\Sunday\Module\Framework\FrameworkModule;
use Ray\Di\Injector;
use Ray\Di\Module\InjectorModule;
use Ray\Di\AbstractModule;

class AppNameModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind()->annotatedWith('app_name')->toInstance('Vendor\App');
    }
}


class FrameworkModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Ray\Di\Injector
     */
    private $injector;

    protected function setUp()
    {
        $this->injector = Injector::create([new AppNameModule, new FrameworkModule, new InjectorModule]);

    }

    public function testInjector()
    {
        $instance = $this->injector->getInstance('Ray\Di\InjectorInterface');
        $this->assertInstanceOf('Ray\Di\InjectorInterface', $instance);
    }

    public function testResource()
    {
        $instance = $this->injector->getInstance('BEAR\Resource\ResourceInterface');
        $this->assertInstanceOf('BEAR\Resource\Resource', $instance);
    }

}
