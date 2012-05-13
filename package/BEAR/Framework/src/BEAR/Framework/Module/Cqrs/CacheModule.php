<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Cqrs;

use BEAR\Framework\Interceptor\CacheLoader as CacheLoadInterceptor;
use BEAR\Framework\Interceptor\CacheUpdater as CacheUpdateInterceptor;
use Guzzle\Common\Cache\CacheAdapterInterface;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\Di\Scope;

/**
 * Cache module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class CacheModule extends AbstractModule
{
	/**
	 * Cache adapter
	 * 
	 * @var Guzzle\Common\Cache\CacheAdapterInterface
	 */
	private $cacheAdapter;
	
	/**
	 * Constructor
	 * 
	 * @param AbstractCacheAdapter $cacheAdapter
	 */
	public function __construct(CacheAdapterInterface $cacheAdapter)
	{
		$this->cacheAdapter = $cacheAdapter;
		parent::__construct();
	}
	
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $cacheLoadInterceptor = new CacheLoadInterceptor($this->cacheAdapter);
        
        // bind @Cache annotatated method in any class
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith('BEAR\Framework\Annotation\Cache'),
            [$cacheLoadInterceptor]
        );
        $cacheUpdateInterceptor = Injector::create()->getInstance('BEAR\Framework\Interceptor\CacheUpdater', ['cache' => $cacheLoadInterceptor]);
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith('BEAR\Framework\Annotation\CacheUpdate'),
            [$cacheUpdateInterceptor]
        );
    }
}
