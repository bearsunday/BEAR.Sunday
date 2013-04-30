<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Exception;

use Exception;

/**
 * Interface for exception handler
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
