<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Extension\ApplicationLogger;

use BEAR\Resource\LoggerInterface as ResourceLoggerInterface;
use BEAR\Sunday\Extension\Application\AppInterface;
use BEAR\Sunday\Extension\ExtensionInterface;
use Ray\Di\Di\Inject;

/**
 * Extension interface for application logger
 */
interface ApplicationLoggerInterface extends ExtensionInterface
{
    /**
     * Set resource logger
     *
     * @param ResourceLoggerInterface $resourceLogger
     *
     * @Inject
     */
    public function __construct(ResourceLoggerInterface $resourceLogger);

    /**
     * Register log function on shutdown
     *
     * called in bootstrap
     *
     * @param AppInterface $app
     */
    public function register(AppInterface $app);
}
