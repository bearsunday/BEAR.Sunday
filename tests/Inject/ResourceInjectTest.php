<?php

declare(strict_types=1);

namespace BEAR\Sunday\Inject;

use BEAR\Resource\ResourceInterface;
use BEAR\Sunday\Module\Resource\ResourceModule;
use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;

class ResourceInjectTest extends TestCase
{
    public function testInjectTrait()
    {
        $app = (new Injector(new ResourceModule))->getInstance(__NAMESPACE__ . '\ResourceInjectApplication');
        $this->assertInstanceOf(ResourceInterface::class, $app->returnDependency());
    }
}
