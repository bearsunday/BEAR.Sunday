<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Application;

use BEAR\Sunday\Application\AppContext;
use BEAR\Sunday\Application\ResourceLogIterator;
use BEAR\Resource\LoggerInterface as ResourceLoggerInterface;
use BEAR\Resource\Logger as ResourceLogger;
use Ray\Di\Di\Inject;

/**
 * Logger
 *
 * @package BEAR.Framework
 */
final class Logger implements LoggerInterface
{
    /**
     * Resorce logger
     *
     * @var ResourceLogger
     */
    private $resourceLogger;

    /**
     * Set resource logger
     *
     * @param ResourceLoggerInterface $resourceLogger
     *
     * @Inject
     */
    public function __construct(ResourceLoggerInterface $resourceLogger)
    {
        $this->resourceLogger = $resourceLogger;
    }

    /**
     * (non-PHPdoc)
     * @see BEAR\Sunday\Application.LoggerInterface::log()
     */
    private function logOnShutdown(AppContext $app)
    {
        $logs = new ResourceLogIterator($this->resourceLogger);
        foreach ($logs as $log) {
            $log->apcLog();
        }
        unset($app);
        // @todo to enable store $app, eliminate all unserializable object.
        // apc_store('request-' . get_class($app), var_export($app, true));
    }

    /**
     * (non-PHPdoc)
     * @see BEAR\Sunday\Application.LoggerInterface::register()
     */
    public function register(AppContext $app)
    {
        register_shutdown_function(
            function () use ($app) {
                $logOnShutdown = [$this, 'logOnShutdown'];
                $logOnShutdown($app);
            }
        );
    }

    /**
     * Output web console log (FirePHP log)
     *
     * @return void
     */
    public function outputWebConsoleLog()
    {
        $logs = new ResourceLogIterator($this->resourceLogger);
        foreach ($logs as $log) {
            $log->fire();
        }
    }
}
