<?php

namespace BEAR\Sunday\Inject;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Ray\Di\AbstractModule;

class PsrLoggerModule extends AbstractModule
{
    protected function configure(): void
    {
        $this->bind(LoggerInterface::class)->to(NullLogger::class);
    }
}
