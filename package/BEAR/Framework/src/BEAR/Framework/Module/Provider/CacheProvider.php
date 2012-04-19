<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Provider;

use BEAR\Framework\Inject\LogInject;
use Doctrine\Common\Cache\ApcCache as Cache;
use Guzzle\Common\Cache\DoctrineCacheAdapter as CacheAdapter;
use Ray\Di\ProviderInterface as Provide;

/**
 * Cache
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class CacheProvider implements Provide
{
    use LogInject;

    /**
     * Return instance
     * 
     * @return CacheAdapter
     */
    public function get()
    {
        $this->log->log('Cache installed');
        return new CacheAdapter(new Cache);
    }
}
