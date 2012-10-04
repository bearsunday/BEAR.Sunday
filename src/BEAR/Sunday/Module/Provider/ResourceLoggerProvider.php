<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
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
 * @package BEAR.Framework
 * @see https://github.com/auraphp/Aura.Web.git
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
     * Looger instance
     *
     * @var BEAR\Resource\Logger
     */
    private static $instance;

    /**
     * Return instance
     *
     * @return Context
     */
    public function get()
    {
        if (! self::$instance) {
            self::$instance = $this->logger;
        }

        return self::$instance;
    }
}
