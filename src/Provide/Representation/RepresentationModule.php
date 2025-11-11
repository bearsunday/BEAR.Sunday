<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Representation;

use BEAR\Resource\JsonRenderer;
use BEAR\Resource\RenderInterface;
use Override;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;

final class RepresentationModule extends AbstractModule
{
    #[Override]
    protected function configure(): void
    {
        $this->bind(RenderInterface::class)->to(JsonRenderer::class)->in(Scope::SINGLETON);
    }
}
