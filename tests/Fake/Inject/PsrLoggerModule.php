<?php

namespace BEAR\Sunday\Inject;

use Ray\Di\AbstractModule;

class PsrLoggerModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind('Psr\Log\LoggerInterface')->to(__NAMESPACE__ . '\DummyLogger');
    }
}
