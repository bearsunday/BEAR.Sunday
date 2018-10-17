<?php

declare(strict_types=1);

namespace BEAR\Sunday\Module\Cache;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\Cache;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;

class DoctrineCacheModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->bind(Cache::class)->to(ArrayCache::class)->in(Scope::SINGLETON);
    }
}
