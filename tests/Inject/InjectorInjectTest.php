<?php

namespace BEAR\Sunday\Inject;

use Ray\Di\Injector;
use Ray\Di\Module\InjectorModule;

class InjectorApplication
{
    use InjectorInject;

    public function returnDependency()
    {
        return $this->injector;
    }

}

class InjectorInjectTest extends \PHPUnit_Framework_TestCase
{
    public function testInjectTrait()
    {
        $app = Injector::create([new InjectorModule])->getInstance(__NAMESPACE__ . '\InjectorApplication');
        $this->assertInstanceOf('Ray\Di\InjectorInterface', $app->returnDependency());
    }
}