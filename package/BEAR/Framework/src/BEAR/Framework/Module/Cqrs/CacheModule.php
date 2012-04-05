<?php
/**
 * Module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
namespace BEAR\Framework\Module\Cqrs;

use Ray\Di\Scope;
use Guzzle\Common\Cache\ZendCacheAdapter as CacheAdapter;;
use Zend\Cache\Backend\File as CacheBackEnd;
use BEAR\Framework\Interceptor\CacheLoader as CacheLoadInterceptor;
use BEAR\Framework\Interceptor\CacheUpdater as CacheUpdateInterceptor;

use Ray\Di\AbstractModule;
use Ray\Di\Injector;

/**
 * DBAL module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class CacheModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $cacheLoadInterceptor = new CacheLoadInterceptor(new CacheAdapter(new CacheBackEnd));
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
