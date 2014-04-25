<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Resource;

use BEAR\Resource\LoggerInterface;
use BEAR\Sunday\Extension\Application\AppInterface;
use Ray\Di\ProviderInterface;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

class ResourceLoggerProvider implements ProviderInterface
{
    /**
     * @var \BEAR\Resource\Logger
     */
    private static $instance;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     *
     * @Inject
     * @Named("resource_logger")
     */
    public function setLoggerClassName(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     *
     * @return AppInterface
     */
    public function get()
    {
        if (!self::$instance) {
            self::$instance = $this->logger;
        }

        return self::$instance;
    }
}
