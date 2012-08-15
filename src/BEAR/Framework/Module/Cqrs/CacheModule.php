<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Cqrs;

use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Guzzle\Common\Cache\CacheAdapterInterface;

/**
 * Cache module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class CacheModule extends AbstractModule
{
    /**
     * @var CacheAdapterInterface
     */
    private $cache;

    public function __construct(CacheAdapterInterface $cache)
    {
        $this->cache = $cache;
        parent::__construct();
    }

    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $cacheLoader = Injector::create()->getInstance('BEAR\Framework\Interceptor\CacheLoader', ['cache' => $this->cache]);
        // bind @Cache annotatated method in any class
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith('BEAR\Framework\Annotation\Cache'),
            [$cacheLoader]
        );
    }
}
