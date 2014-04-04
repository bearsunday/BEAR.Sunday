<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Inject;

use Psr\Log\LoggerInterface;

/**
 * Inject PSR-logger
 */
trait PsrLoggerInject
{
    /**
     * Logger
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * PSR Logger setter
     *
     * @param LoggerInterface $logger
     *
     * @return void
     * @Ray\Di\Di\Inject
     */
    public function setPsrLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
