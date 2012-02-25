<?php

namespace BEAR\Framework\Module\Provider;

use Ray\Di\ProviderInterface;

use Doctrine\Common\Cache\ApcCache as Cache;
use Guzzle\Common\Cache\DoctrineCacheAdapter as CacheAdapter;

/**
 * Cache
 *
 */
class CacheProvider implements ProviderInterface
{
    /**
     * @return Guzzle\Common\Cache\DoctrineCacheAdapter
     */
    public function get()
    {
        return new CacheAdapter(new Cache);
    }
}
