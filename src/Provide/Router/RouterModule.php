<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Router;

use BEAR\Sunday\Annotation\DefaultSchemeHost;
use BEAR\Sunday\Extension\Router\RouterInterface;
use Ray\Di\AbstractModule;

/**
 * Provides RouterInterface and derived bindings
 *
 * The following bindings are provided:
 *
 *  RouterInterface
 *  -DefaultSchemeHost
 */
class RouterModule extends AbstractModule
{
    protected function configure(): void
    {
        $this->bind(RouterInterface::class)->to(WebRouter::class);
        $this->bind()->annotatedWith(DefaultSchemeHost::class)->toInstance('page://self');
    }
}
