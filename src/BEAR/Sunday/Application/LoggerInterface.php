<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Application;

use BEAR\Sunday\Application\ContextInterface;

use Ray\Di\Di\ImplementedBy;

/**
 * Interface for application logger
 *
 * @package BEAR.Sunday
 *
 * @ImplementedBy("BEAR\Sunday\Application\Logger")
 */
interface LoggerInterface
{
    /**
     * Register log function on shutdown
     *
     * @param Context $app
     */
    public function register(ContextInterface $app);
}
