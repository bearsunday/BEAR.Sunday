<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Exception;

use Exception;

/**
 * Interface for exception handler
 *
 * @package BEAR.Framework
 */
interface ExceptionHandlerInterface
{
    /**
     * Handle exception
     *
     * @param Exception $e
     */
    public function handle(Exception $e);
}
