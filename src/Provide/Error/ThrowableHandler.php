<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Error;

use BEAR\Resource\Exception\BadRequestException;
use BEAR\Resource\Exception\JsonSchemaRequestException;
use BEAR\Sunday\Extension\Error\ErrorInterface;
use BEAR\Sunday\Extension\Error\ThrowableHandlerInterface;
use BEAR\Sunday\Extension\Router\RouterMatch as Request;
use Error;
use ErrorException;
use Exception;
use Override;
use Throwable;

use const E_ERROR;

final class ThrowableHandler implements ThrowableHandlerInterface
{
    public function __construct(
        private ErrorInterface $error,
    ) {
    }

    #[Override]
    public function handle(Throwable $e, Request $request): ThrowableHandlerInterface
    {
        if ($e instanceof Error) {
            $e = new ErrorException($e->getMessage(), $e->getCode(), E_ERROR, $e->getFile(), $e->getLine(), $e);
        }

        if ($e instanceof JsonSchemaRequestException) {
            $e = new BadRequestException($e->getMessage(), $e->getCode(), $e);
        }

        /** @var Exception $e */
        $this->error->handle($e, $request);

        return $this;
    }

    #[Override]
    public function transfer(): void
    {
        $this->error->transfer();
    }
}
