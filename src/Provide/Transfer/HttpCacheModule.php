<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Sunday\Extension\Transfer\HttpCacheInterface;
use BEAR\Sunday\Extension\Transfer\NullHttpCache;
use Ray\Di\AbstractModule;

/**
 * Provides HttpCacheInterface bindings
 */
class HttpCacheModule extends AbstractModule
{
    protected function configure(): void
    {
        $this->bind(HttpCacheInterface::class)->to(NullHttpCache::class);
    }
}
