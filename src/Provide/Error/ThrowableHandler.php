<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Error;

use BEAR\Sunday\Extension\Error\ErrorInterface;
use BEAR\Sunday\Extension\Error\ThrowableHandlerInterface;
use BEAR\Sunday\Extension\Router\RouterMatch as Request;
use Error;
use ErrorException;
use Exception;
use Throwable;

use function assert;

use const E_ERROR;

final class ThrowableHandler implements ThrowableHandlerInterface
{
    public function __construct(
        private ErrorInterface $error,
    ) {
    }

    public function handle(Throwable $e, Request $request): ThrowableHandlerInterface
    {
        $e = $e instanceof Error ? new ErrorException($e->getMessage(), $e->getCode(), E_ERROR, $e->getFile(), $e->getLine()) : $e;
        assert($e instanceof Exception);
        $this->error->handle($e, $request);

        return $this;
    }

    public function transfer(): void
    {
        $this->error->transfer();
    }
}
