<?php

declare(strict_types=1);

namespace BEAR\Sunday\Extension\Transfer;

use Override;

final class NullHttpCache implements HttpCacheInterface
{
    /**
     * {@inheritDoc}
     */
    #[Override]
    public function isNotModified(array $server): bool
    {
        return false;
    }

    #[Override]
    public function transfer(): void
    {
    }
}
