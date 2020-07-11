<?php

declare(strict_types=1);

namespace BEAR\Sunday\Extension\Error;

use BEAR\Sunday\Extension\Router\RouterMatch as Request;
use Throwable;

interface ThrowableHandlerInterface
{
    /**
     * Handle Throwable
     */
    public function handle(Throwable $e, Request $request): self;

    /**
     * Transfer error page
     */
    public function transfer(): void;
}
