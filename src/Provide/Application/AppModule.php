<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Application;

use BEAR\Resource\Annotation\AppName;
use BEAR\Sunday\Extension\Application\AppInterface;
use Ray\Di\AbstractModule;

class AppModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(AppInterface::class)->to(App::class);
        $this->bind()->annotatedWith(AppName::class)->toInstance('BEAR\Sunday');
    }
}
