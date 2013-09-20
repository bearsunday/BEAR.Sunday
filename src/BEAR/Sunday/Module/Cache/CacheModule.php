<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Cache;

use Ray\Di\AbstractModule;
use Ray\Di\Di\Scope;

/**
 * Cache module
 */
class CacheModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->bind('Guzzle\Cache\AbstractCacheAdapter')
            ->toProvider('BEAR\Sunday\Module\Cache\CacheProvider')
            ->in(Scope::SINGLETON);
    }
}
