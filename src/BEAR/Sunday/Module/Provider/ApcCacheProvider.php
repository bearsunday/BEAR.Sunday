<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Provider;

use Doctrine\Common\Cache\ApcCache as Cache;
use Guzzle\Common\Cache\DoctrineCacheAdapter as CacheAdapter;
use Ray\Di\ProviderInterface as Provide;

/**
 * Cache
 *
 * @package    BEAR.Sunday
 * @subpackage Module
 */
class ApcCacheProvider implements Provide
{

    /**
     * Return instance
     *
     * @return CacheAdapter
     */
    public function get()
    {
        $cache = new CacheAdapter(new Cache);

        return $cache;
    }
}
