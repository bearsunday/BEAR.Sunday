<?php

declare(strict_types=1);

namespace BEAR\Sunday\Extension\Error;

use BEAR\Sunday\Extension\Router\RouterMatch as Request;
use Exception;
use Override;

final class NullError implements ErrorInterface
{
    /**
     * {@inheritDoc}
     */
    #[Override]
    public function handle(Exception $e, Request $request) // phpcs:disable SlevomatCodingStandard.Exceptions.ReferenceThrowableOnly.ReferencedGeneralException
    {
        return $this;
    }

    #[Override]
    public function transfer(): void
    {
    }
}
