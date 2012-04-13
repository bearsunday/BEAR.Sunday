<?php
/**
 * BEAR.Framework;
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Provider;

use Ray\Di\ProviderInterface as Provide;
use Doctrine\Common\Cache\ApcCache as Cache;
use Guzzle\Common\Cache\DoctrineCacheAdapter as CacheAdapter;
use BEAR\Framework\Inject\LogInject;;

/**
 * Cache
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
class CacheProvider implements Provide
{
    use LogInject;

    /**
     * @return CacheAdapter
     */
    public function get()
    {
        $this->log->log('Cache installed');
        return new CacheAdapter(new Cache);
    }
}
