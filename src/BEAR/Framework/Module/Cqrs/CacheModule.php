<?php
/**
 * This file is part of the BEAR.Framework package
 *
 * @package BEAR.Framework
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module\Cqrs;

use Ray\Di\Di\Inject;
use Ray\Di\AbstractModule;
use Ray\Di\InjectorInterface;
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
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $cacheLoader = $this->requestInjection('BEAR\Framework\Interceptor\CacheLoader');
        // bind @Cache annotatated method in any class
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith('BEAR\Framework\Annotation\Cache'),
            [$cacheLoader]
        );
        $cacheUpdater = $this->requestInjection('BEAR\Framework\Interceptor\CacheUpdater');
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith('BEAR\Framework\Annotation\CacheUpdate'),
            [$cacheUpdater]
        );
    }
}
