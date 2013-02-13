<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Provider;

use Doctrine\Common\Cache\ApcCache;
use Guzzle\Cache\DoctrineCacheAdapter as CacheAdapter;
use Ray\Di\ProviderInterface as Provide;
use BEAR\Sunday\Inject\TmpDirInject;
use Doctrine\Common\Cache\FilesystemCache;

/**
 * Cache
 *
 * @package    BEAR.Sunday
 * @subpackage Module
 */
class ApcCacheProvider implements Provide
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
            $cache = new CacheAdapter(new ApcCache);
        } else {
            $cache = new CacheAdapter(new FilesystemCache($this->tmpDir));
        }

        return $cache;
    }
}
