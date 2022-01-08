<?php

namespace BEAR\Sunday\Inject;

use Psr\Log\LoggerInterface;
use Ray\Di\AbstractModule;

class PsrLoggerModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind(LoggerInterface::class)->toNull();
    }
}
