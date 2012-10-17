<?php
/**
 * This file is part of the BEAR.Sunday package
 *
 * @package BEAR.Sunday
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Sunday\Module\Resource;

use Ray\Di\AbstractModule;


/**
 * Resource cache APC module
 *
 * @package    BEAR.Sunday
 * @subpackage Module
 */
class ApcModule extends AbstractModule
{
    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->bind('Guzzle\Common\Cache\CacheAdapterInterface')
            ->annotatedWith('resource_cache')
            ->toProvider('BEAR\Sunday\Module\Provider\ApcCacheProvider');
    }
}
