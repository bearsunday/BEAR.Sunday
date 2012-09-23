<?php
/**
 * Module
 *
 * @package    sandbox
 * @subpackage Module
 */
namespace sandbox\Module;

use BEAR\Framework\Module;
use BEAR\Framework\Module\FrameworkModule;
use BEAR\Framework\Module\NamedModule;
use BEAR\Framework\Module\TemplateEngine;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;

/**
 * Dev module
 *
 * @package    sandbox
 * @subpackage Module
 */
class DevModule extends AbstractModule
{
    /**
     * (non-PHPdoc)
     * @see Ray\Di.AbstractModule::configure()
     */
    protected function configure()
    {
        $this->installConstants();
        $this->installDevTool();
        $this->install(new FrameworkModule($this));
        $this->installDevLogger();
        $this->installResourceCache();
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

    /**
     * Provide debug information
     */
    private function installDevTool()
    {
        $this->bind('BEAR\Resource\InvokerInterface')->to('BEAR\Resource\DevInvoker');
        $this->install(new TemplateEngine\DevRendererModule);
    }

    /**
     * Provide debug information
     *
     * depends FrameworkModule
     */
    private function installDevLogger()
    {
        $logger = $this->requestInjection('BEAR\Framework\Interceptor\Logger');
        $this->bindInterceptor(
            $this->matcher->subclassesOf('BEAR\Resource\Object'),
            $this->matcher->annotatedWith('BEAR\Framework\Annotation\Log'),
            [$logger]
        );
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
