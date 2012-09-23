<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Application;

use BEAR\Framework\AppContext;
use Ray\Di\Di\ImplementedBy;

/**
 * Interface for application logger
 *
 * @package BEAR.Framework
 *
 * @ImplementedBy("BEAR\Framework\Application\Logger")
 */
interface LoggerInterface
{
    /**
     * Regster log function on shutddown
     *
     * @return void
     */
    public function register(AppContext $app);
}
