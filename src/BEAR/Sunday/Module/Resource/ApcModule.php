<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Resource;

use Ray\Di\AbstractModule;

/**
 * Resource cache module
 */
class ApcModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->bind('Guzzle\Cache\CacheAdapterInterface')
            ->annotatedWith('resource_cache')
            ->toProvider('BEAR\Sunday\Module\Provider\ApcCacheProvider');
    }
}
