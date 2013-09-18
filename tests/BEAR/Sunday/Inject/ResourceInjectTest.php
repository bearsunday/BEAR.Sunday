<?php

namespace BEAR\Sunday\Inject;

use Ray\Di\Injector;
use BEAR\Sunday\Module\Resource\ResourceModule;

class ResourceApplication
{
    use ResourceInject;

    public function returnDependency()
    {
        return $this->resource;
    }

}

class ResourceInjectTest extends \PHPUnit_Framework_TestCase
{
    public function testInjectTrait()
    {
        $app = Injector::create([new ResourceModule])->getInstance(__NAMESPACE__ . '\ResourceApplication');
        $this->assertInstanceOf('BEAR\Resource\ResourceInterface', $app->returnDependency());
    }
}