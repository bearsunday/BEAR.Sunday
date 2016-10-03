<?php

namespace BEAR\Sunday\Inject;

use BEAR\Resource\ResourceInterface;
use BEAR\Sunday\Module\Resource\ResourceModule;
use Ray\Di\Injector;

class ResourceInjectTest extends \PHPUnit_Framework_TestCase
{
    public function testInjectTrait()
    {
        $app = (new Injector(new ResourceModule))->getInstance(__NAMESPACE__ . '\ResourceInjectApplication');
        $this->assertInstanceOf(ResourceInterface::class, $app->returnDependency());
    }
}
