<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Representation;

use BEAR\Resource\JsonRenderer;
use BEAR\Resource\RenderInterface;
use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;

class RepresentationModuleTest extends TestCase
{
    public function testRenderer()
    {
        $renderer = (new Injector(new RepresentationModule))->getInstance(RenderInterface::class);
        $this->assertInstanceOf(JsonRenderer::class, $renderer);
    }
}
