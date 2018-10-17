<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Router;

use BEAR\Sunday\Annotation\DefaultSchemeHost;
use BEAR\Sunday\Extension\Router\RouterInterface;
use Ray\Di\AbstractModule;

class RouterModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(RouterInterface::class)->to(WebRouter::class);
        $this->bind()->annotatedWith(DefaultSchemeHost::class)->toInstance('page://self');
    }
}
