<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Sunday\Extension\Transfer\HttpCacheInterface;
use BEAR\Sunday\Extension\Transfer\NullHttpCache;
use Override;
use Ray\Di\AbstractModule;

/**
 * Provides HttpCacheInterface bindings
 */
final class HttpCacheModule extends AbstractModule
{
    #[Override]
    protected function configure(): void
    {
        $this->bind(HttpCacheInterface::class)->to(NullHttpCache::class);
    }
}
