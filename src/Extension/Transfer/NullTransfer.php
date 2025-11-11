<?php

declare(strict_types=1);

namespace BEAR\Sunday\Extension\Transfer;

use BEAR\Resource\ResourceObject;
use Override;

final class NullTransfer implements TransferInterface
{
    /**
     * {@inheritDoc}
     *
     * @codeCoverageIgnore
     */
    #[Override]
    public function __invoke(ResourceObject $ro, array $server): void
    {
    }
}
