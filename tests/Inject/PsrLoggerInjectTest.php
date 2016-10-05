<?php

namespace BEAR\Sunday\Inject;

use Ray\Di\Injector;

class PsrLoggerInjectTest extends \PHPUnit_Framework_TestCase
{
    public function testInjectTrait()
    {
        $app = (new Injector(new PsrLoggerModule))->getInstance(__NAMESPACE__ . '\PsrLoggerApplication');
        $this->assertInstanceOf('\BEAR\Sunday\Inject\DummyLogger', $app->returnDependency());
    }
}
