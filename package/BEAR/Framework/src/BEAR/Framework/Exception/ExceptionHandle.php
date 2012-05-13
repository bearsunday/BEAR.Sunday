<?php
namespace BEAR\Framework\Exception;

use Ray\Di\Di\ImplementedBy;
use Exception;

interface ExceptionHandle
{
    /**
     * Handle exception
     * 
     * @param Exception $e
     */
    public function handle(Exception $e);
}