<?php

namespace BEAR\Sunday\Inject;

use BEAR\Resource\Module\ResourceModule;
use Ray\Di\Injector;

class AApplication
{
    use AInject;

    public function returnDependency()
    {
        return $this->a;
    }

}

class AInjectTest extends \PHPUnit_Framework_TestCase
{
    public function testCacheApc()
    {
        $app = Injector::create([new ResourceModule])->getInstance(__NAMESPACE__ . '\AApplication');
        $this->assertInstanceOf('BEAR\Resource\A', $app->returnDependency());
    }
}