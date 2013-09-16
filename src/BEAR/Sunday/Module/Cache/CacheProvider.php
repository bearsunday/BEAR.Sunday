<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Cache;

use BEAR\Sunday\Inject\TmpDirInject;
use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\FilesystemCache;
use Guzzle\Cache\DoctrineCacheAdapter as CacheAdapter;
use Ray\Di\ProviderInterface as Provide;

/**
 * Cache provider
 *
 * (primary:APC, secondary:FileCache)
 */
class CacheProvider implements Provide
{
    use TmpDirInject;

    /**
     * Return instance
     *
     * @return CacheAdapter
     */
    public function get()
    {
        if (function_exists('apc_cache_info')) {
            return new CacheAdapter(new ApcCache);
        }

        return new CacheAdapter(new FilesystemCache($this->tmpDir . '/cache'));
    }
}
