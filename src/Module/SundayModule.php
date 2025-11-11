<?php

declare(strict_types=1);

namespace BEAR\Sunday\Module;

use BEAR\Resource\Module\ResourceModule;
use BEAR\Sunday\Provide\Error\ErrorModule;
use BEAR\Sunday\Provide\Router\RouterModule;
use BEAR\Sunday\Provide\Transfer\HttpCacheModule;
use BEAR\Sunday\Provide\Transfer\HttpResponderModule;
use Override;
use Ray\Di\AbstractModule;

/**
 * Provides BEAR.Sunday base bindings
 */
final class SundayModule extends AbstractModule
{
    #[Override]
    protected function configure(): void
    {
        $this->install(new HttpCacheModule());
        $this->install(new ResourceModule());
        $this->install(new RouterModule());
        $this->install(new HttpResponderModule());
        $this->install(new ErrorModule());
    }
}
