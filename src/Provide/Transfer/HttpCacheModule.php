<?php

declare(strict_types=1);

namespace BEAR\Sunday\Provide\Transfer;

use BEAR\Sunday\Extension\Transfer\HttpCacheInterface;
use BEAR\Sunday\Extension\Transfer\NullHttpCache;
use Ray\Di\AbstractModule;

class HttpCacheModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind(HttpCacheInterface::class)->to(NullHttpCache::class);
    }
}
