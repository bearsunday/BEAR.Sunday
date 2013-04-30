<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Provider;

use BEAR\Sunday\Inject\TmpDirInject;
use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\FilesystemCache;
use Guzzle\Cache\DoctrineCacheAdapter as CacheAdapter;
use Ray\Di\ProviderInterface as Provide;

/**
 * Apc cache provider
 */
class ApcCacheProvider implements Provide
{
    use TmpDirInject;

    /**
     * @return CacheAdapter
     */
    public function get()
    {
        if (function_exists('apc_cache_info')) {
            $cache = new CacheAdapter(new ApcCache);
        } else {
            $cache = new CacheAdapter(new FilesystemCache($this->tmpDir . '/cache'));
        }

        return $cache;
    }
}
