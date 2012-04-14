<?php
/**
 * BEAR.Framework
 *
 * @package BEAR.Resource
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module;

use Ray\Di\Injector;
use Ray\Di\AbstractModule;
use BEAR\Framework\Module\Log;
use Ray\Di\Scope;

/**
 * Application module
 *
 * @package    sandbox
 * @subpackage Module
 */
class FrameworkModule extends AbstractModule
{
    /**
     * App class
     *
     * @var string
     */
    private $appDir;

    /**
     *
     * @param string $app
     */
    public function __construct($app)
    {
        $this->app = $app;
        parent::__construct();
    }

    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        // bind
        $app = $this->app;
        $tmpDir = $app::DIR . '/tmp';
        $logDir = $app::DIR . '/log';
        $this->bind()->annotatedWith("tmp_dir")->toInstance($tmpDir);
        $this->bind()->annotatedWith("log_dir")->toInstance($logDir);

        // install
        $this->install(new Log\MonologModule);
        $this->installCoreModule();
    }

    /**
     * Core Module
     */
    private function installCoreModule()
    {
        $injector = Injector::create();
        $config = $injector->getContainer()->getForge()->getConfig();
        $this->bind('Aura\Di\ConfigInterface')->toInstance($config);
        $this->bind('Ray\Di\InjectorInterface')->toInstance($injector);
        $this->bind('BEAR\Resource\Resource')->to('BEAR\Resource\Client')->in(Scope::SINGLETON);
        $this->bind('BEAR\Resource\Invokable')->to('BEAR\Resource\Invoker')->in(Scope::SINGLETON);
        $this->bind('BEAR\Resource\Linkable')->to('BEAR\Resource\Linker')->in(Scope::SINGLETON);
        $this->bind('Guzzle\Common\Cache\AbstractCacheAdapter')->toProvider('BEAR\Framework\Module\Provider\CacheProvider')->in(Scope::SINGLETON);
        $this->bind('Aura\Signal\Manager')->toProvider('BEAR\Framework\Module\Provider\SignalProvider')->in(Scope::SINGLETON);
        $app = $this->app;
        $this->bind()->annotatedWith('app_name')->toInstance($app::NAME);
        $this->bind('BEAR\Framework\Web\Response')->to('BEAR\Framework\Web\HttpFoundation');
    }
}