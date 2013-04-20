<?php

namespace BEAR\Sunday\Module\Framework;

use BEAR\Sunday\Module\Framework\FrameworkModule;
use Ray\Di\Injector;

class FrameworkModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Ray\Di\Injector
     */
    private $injector;

    protected function setUp()
    {
        $this->injector = Injector::create(
            [
                new FrameworkModule
            ]
        );

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
