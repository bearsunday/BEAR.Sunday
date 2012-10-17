<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Provider;

use Ray\Di\ProviderInterface;
use BEAR\Resource\LoggerInterface;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

/**
 * Resource logger
 *
 * @package BEAR.Sunday
 * @see     https://github.com/auraphp/Aura.Web.git
 */
class ResourceLoggerProvider implements ProviderInterface
{
    /**
     * Set logger name
     *
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
     * Logger instance
     *
     * @var \BEAR\Resource\Logger
     */
    private static $instance;

    /**
     * Return instance
     *
     * @return Context
     */
    public function get()
    {
        if (!self::$instance) {
            self::$instance = $this->logger;
        }

        return self::$instance;
    }
}
