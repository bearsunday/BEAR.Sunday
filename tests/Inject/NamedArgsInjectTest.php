<?php

namespace BEAR\Sunday\Inject;

use Ray\Di\Injector;
use BEAR\Sunday\Module\Aop\NamedArgsModule;

class NamedArgsApplication
{
    use NamedArgsInject;

    public function returnDependency()
    {
        return $this->namedArgs;
    }

}

class NamedArgsInjectTest extends \PHPUnit_Framework_TestCase
{
    public function testInjectTrait()
    {
        $app = Injector::create([new NamedArgsModule])->getInstance(__NAMESPACE__ . '\NamedArgsApplication');
        $this->assertInstanceOf('Ray\Aop\NamedArgsInterface', $app->returnDependency());
    }
}
