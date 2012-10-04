<?php
/**
 * Module
 *
 * @package    Helloworld
 * @subpackage Module
 */
namespace Helloworld\Module;

use BEAR\Sunday\Module\FrameworkModule;

use BEAR\Sunday\Module;
use Ray\Di\AbstractModule;

/**
 * Application module
 *
 * @package    Helloworld
 * @subpackage Module
 */
class AppModule extends AbstractModule
{
    /**
     * (non-PHPdoc)
     * @see Ray\Di.AbstractModule::configure()
     */
    protected function configure()
    {
        $config = require __DIR__ . '/config.php';
        $this->install(new Module\NamedModule($config));
        $this->installResourceCache();
        $this->install(new FrameworkModule($this));
        $this->install(new Module\SchemeModule( __NAMESPACE__ . '\SchemeCollectionProvider'));
    }

    /**
     * Bind resource_cache to APC
     */
    private function installResourceCache()
    {
        $this
        ->bind('Guzzle\Common\Cache\CacheAdapterInterface')
        ->annotatedWith('resource_cache')
        ->toProvider('BEAR\Sunday\Module\Provider\ApcCacheProvider');
    }
}
