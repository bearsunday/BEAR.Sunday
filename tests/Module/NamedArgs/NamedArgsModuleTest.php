<?php

namespace BEAR\Sunday\Module\NamedArgs;

use BEAR\Sunday\Module\Aop\NamedArgsModule;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\Aop\NamedArgsInterface;
use Ray\Di\Di\Inject;

class Application
{
    public $namedArgs;

    /**
     * @Inject
     */
    public function setCache(NamedArgsInterface $namedArgs)
    {
        $this->namedArgs = $namedArgs;
    }
}

class NamedArgsTest extends \PHPUnit_Framework_TestCase
{
    public function testCacheApc()
    {
        $app = Injector::create([new NamedArgsModule])->getInstance(__NAMESPACE__ . '\Application');
        $this->assertInstanceOf('Ray\Aop\NamedArgsInterface' , $app->namedArgs);
    }
}
