<?php

namespace BEAR\Sunday\Inject;

use Psr\Log\LoggerInterface;

class PsrLoggerApplication
{
    use PsrLoggerInject;

    public function returnDependency(): LoggerInterface
    {
        return $this->logger;
    }
}
