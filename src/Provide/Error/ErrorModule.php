<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Error;

use BEAR\Sunday\Extension\Error\ErrorInterface;
use BEAR\Sunday\Extension\Error\ThrowableHandlerInterface;
use BEAR\Sunday\Extension\Provide\ThrowableHandler;
use Ray\Di\AbstractModule;

class ErrorModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure() : void
    {
        $this->bind(ErrorInterface::class)->to(VndError::class);
        $this->bind(ThrowableHandlerInterface::class)->to(ThrowableHandler::class);
    }
}
