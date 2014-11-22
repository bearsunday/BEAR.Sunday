<?php

namespace BEAR\Sunday\Module\Resource;

use BEAR\Resource\ResourceInterface;
use Ray\Di\Injector;

class ResourceModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $resource = (new Injector(new ResourceModule))->getInstance(ResourceInterface::class);
        $this->assertInstanceOf(ResourceInterface::class, $resource);
    }
}
