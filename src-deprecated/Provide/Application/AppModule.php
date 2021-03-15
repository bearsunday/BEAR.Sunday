<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Application;

use BEAR\Resource\Annotation\AppName;
use BEAR\Sunday\Extension\Application\AppInterface;
use Ray\Di\AbstractModule;

/**
 * @deprecated
 */
class AppModule extends AbstractModule
{
    protected function configure(): void
    {
        $this->bind(AppInterface::class)->to(App::class);
        $this->bind()->annotatedWith(AppName::class)->toInstance('BEAR\Sunday');
    }
}
