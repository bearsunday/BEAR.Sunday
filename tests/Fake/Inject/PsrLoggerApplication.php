<?php

namespace BEAR\Sunday\Inject;

class PsrLoggerApplication
{
    use PsrLoggerInject;

    public function returnDependency()
    {
        return $this->logger;
    }
}
