<?php

declare(strict_types=1);

namespace BEAR\Sunday\Inject;

use Psr\Log\LoggerInterface;
use Ray\Di\Di\Inject;

trait PsrLoggerInject
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * @\Ray\Di\Di\Inject
     * @codeCoverageIgnore
     */
    #[Inject]
    public function setPsrLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
