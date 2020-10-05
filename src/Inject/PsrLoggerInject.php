<?php

declare(strict_types=1);

namespace BEAR\Sunday\Inject;

use Psr\Log\LoggerInterface;

trait PsrLoggerInject
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * @\Ray\Di\Di\Inject
     * @codeCoverageIgnore
     */
    public function setPsrLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
