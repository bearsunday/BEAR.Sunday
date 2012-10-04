<?php
/**
 * Module
 *
 * @package    Sandbox
 * @subpackage Module
 */
namespace Sandbox\Module;

use BEAR\Framework\Module;
use BEAR\Framework\Module\NamedModule;
use BEAR\Framework\Module\FrameworkModule;
use BEAR\Framework\Module\TemplateEngine;
use Ray\Di\Injector;
use Doctrine\Common\Cache\ApcCache as Cache;
use Ray\Di\AbstractModule;

/**
 * Production module
 *
 * @package    Sandbox
 * @subpackage Module
 */
class ProdModule extends AbstractModule
{
    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('')->annotatedWith('is_prod')->toInstance(true);
        $this->installConstants();
        $this->installCachedAnnotationReader();
        $this->install(new FrameworkModule($this));
        $this->install(new TemplateEngine\ProdRendererModule);
        $this->installResourceCache();

        // install application module
        $this->install(new Common\AppModule($this));
    }

    /**
     * Install config value
     */
    protected function installConstants()
    {
        $config = require __DIR__ . '/config.php';
        $this->install(new NamedModule($config));
    }

    private function installCachedAnnotationReader()
    {
        $this
        ->bind('Doctrine\Common\Annotations\Reader')
        ->toProvider('BEAR\Framework\Module\Provider\CachedReaderProvider');
    }

    /**
     * Bind resource_cache to APC
     */
    private function installResourceCache()
    {
        $this
        ->bind('Guzzle\Common\Cache\CacheAdapterInterface')
        ->annotatedWith('resource_cache')
        ->toProvider('BEAR\Framework\Module\Provider\ApcCacheProvider');
    }
}
