<?php

namespace BEAR\Sunday\Inject;

class PsrLoggerApplication
{
    use PsrLoggerInject;

    public function returnDependency(): \Psr\Log\LoggerInterface
    {
        return $this->logger;
    }
}
