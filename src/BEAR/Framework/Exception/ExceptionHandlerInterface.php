<?php
namespace BEAR\Framework\Exception;

use Exception;

interface ExceptionHandlerInterface
{
    /**
     * Handle exception
     *
     * @param Exception $e
     */
    public function handle(Exception $e);
}
