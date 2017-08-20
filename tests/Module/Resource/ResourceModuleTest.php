<?php

namespace BEAR\Sunday\Module\Resource;

use BEAR\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;

class ResourceModuleTest extends TestCase
{
    public function testGetInstance()
    {
        $resource = (new Injector(new ResourceModule))->getInstance(ResourceInterface::class);
        $this->assertInstanceOf(ResourceInterface::class, $resource);
    }
}
