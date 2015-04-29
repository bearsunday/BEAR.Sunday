<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace BEAR\Sunday\Inject;

use Psr\Log\LoggerInterface;

trait PsrLoggerInject
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     *
     * @Ray\Di\Di\Inject
     */
    public function setPsrLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
