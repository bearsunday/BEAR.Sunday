<?php
/**
 * Module
 *
 * @package    Sandbox
 * @subpackage Module
 */
namespace Sandbox\Module;

use BEAR\Sunday\Module;
use BEAR\Sunday\Module\FrameworkModule;
use BEAR\Sunday\Module\NamedModule;
use BEAR\Sunday\Module\TemplateEngine;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;

/**
 * Dev module
 *
 * @package    Sandbox
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
        $config = include __DIR__ . '/config.php';
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
        $logger = $this->requestInjection('BEAR\Sunday\Interceptor\Logger');
        $this->bindInterceptor(
            $this->matcher->subclassesOf('BEAR\Resource\Object'),
            $this->matcher->annotatedWith('BEAR\Sunday\Annotation\Log'),
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
        ->toProvider('BEAR\Sunday\Module\Provider\ApcCacheProvider');
    }
}
