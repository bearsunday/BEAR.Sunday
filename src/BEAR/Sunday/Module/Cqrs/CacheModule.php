<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Cqrs;

use Ray\Di\AbstractModule;


/**
 * Cache module
 *
 * @package    BEAR.Sunday
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
        $cacheLoader = $this->requestInjection('BEAR\Sunday\Interceptor\CacheLoader');
        // bind @Cache annotated method in any class
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith('BEAR\Sunday\Annotation\Cache'),
            [$cacheLoader]
        );
        $cacheUpdater = $this->requestInjection('BEAR\Sunday\Interceptor\CacheUpdater');
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith('BEAR\Sunday\Annotation\CacheUpdate'),
            [$cacheUpdater]
        );
    }
}
