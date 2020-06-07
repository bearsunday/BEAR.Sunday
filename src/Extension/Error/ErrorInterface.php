<?php

declare(strict_types=1);

namespace BEAR\Sunday\Extension\Error;

use BEAR\Sunday\Extension\Router\RouterMatch as Request;
use Exception;

interface ErrorInterface
{
    /**
     * Handle exception
     *
     * @return self
     */
    public function handle(Exception $e, Request $request);

    /**
     * Error page transfer
     *
     * @return void
     */
    public function transfer();
}
