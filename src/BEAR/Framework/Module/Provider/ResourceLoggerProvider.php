<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Provider;

use Ray\Di\ProviderInterface;
use BEAR\Resource\LoggerInterface;

/**
 * Resource logger
 *
 * @see https://github.com/auraphp/Aura.Web.git
 */
class ResourceLoggerProvider implements ProviderInterface
{
    /**
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
