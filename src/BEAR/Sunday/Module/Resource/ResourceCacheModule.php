<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Resource;

use Ray\Di\AbstractModule;

/**
 * APC Resource cache module
 */
class ResourceCacheModule extends AbstractModule
{
    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->bind('Guzzle\Cache\CacheAdapterInterface')
            ->annotatedWith('resource_cache')
            ->toProvider('BEAR\Sunday\Module\Cache\CacheProvider');
    }
}
