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
use BEAR\Framework\Module\TemplateEngine;
use Ray\Di\Scope;
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
     * App name
     *
     * @var string
     */
    private $app;

    /**
     * Config
     *
     * <$named => $instance>
     * @var array
     */
    private $properties;

    /**
     * Constructor
     *
     * @param string $app
     * @param string $configFile
     */
    public function __construct($app, $configFile = 'config.php')
    {
        $this->app = $app;
        $this->properties = require dirname(__DIR__) . "/scripts/{$configFile}";
        parent::__construct();
    }

    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        foreach ($this->properties as $named => $instance) {
            $this->bind('')->annotatedWith($named)->toInstance($instance);
        }
        // install framework module
        $tmpDir = dirname(__DIR__) . '/tmp';
        $logDir = dirname(__DIR__) . '/log';
        $this->install(new FrameworkModule($this->app, $tmpDir, $logDir));
        // install dev invoker (attach extra dev info to resource)
        $this->bind('BEAR\Resource\InvokerInterface')->to('BEAR\Resource\DevInvoker')->in(Scope::SINGLETON);
        // install dev render (display extra dev info)
        $this->install(new TemplateEngine\DevRendererModule);
        // log resource access with @Log
        $logger = $this->requestInjection('BEAR\Framework\Interceptor\Logger');
        $this->bindInterceptor(
            $this->matcher->subclassesOf('BEAR\Resource\Object'),
            $this->matcher->annotatedWith('BEAR\Framework\Annotation\Log'),
            [$logger]
        );
        $this->bind('Guzzle\Common\Cache\CacheAdapterInterface')->annotatedWith('resource_cache')->toProvider('BEAR\Framework\Module\Provider\ApcCacheProvider');
        // install application module
        $injector = Injector::create([$this]);
        $this->install(new AppModule($injector));
    }
}
