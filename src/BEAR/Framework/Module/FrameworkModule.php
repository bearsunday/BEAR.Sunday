<?php
/**
 * BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework\Module;

use Ray\Di\Injector;
use Ray\Di\AbstractModule;
use BEAR\Framework\Module\Log;
use Ray\Di\Scope;
use ReflectionClass;

/**
 * Application module
 *
 * @package    BEAR.Framework
 * @subpackage Module
 */
class FrameworkModule extends AbstractModule
{
    /**
     * App name
     *
     * @var string
     */
    private $app;

    /**
     * Tmp direcotry
     *
     * @var string
     */
    private $tmpDir;

    /**
     * Log directory
     *
     * @var string
     */
    private $logDir;

    /**
     * Constructor
     *
     * @param string $app    App name (=namespace name)
     * @param string $tmpDir
     * @param string $logDir
     */
    public function __construct($app, $tmpDir, $logDir)
    {
        $this->app = $app;
        $this->tmpDir = $tmpDir;
        $this->logDir = $logDir;
        parent::__construct();
    }

    /**
     * Configure
     *
     * @return void
     */
    protected function configure()
    {
        // bind dir
        $this->bind()->annotatedWith("app")->toInstance($this->app);
        // tmp dir
        $this->bind()->annotatedWith("tmp_dir")->toInstance($this->tmpDir);
        // log dir
        $this->bind()->annotatedWith("log_dir")->toInstance($this->logDir);
        // view template dir
        $appDir = dirname((new ReflectionClass("{$this->app}\App"))->getFileName());
        $this->bind()->annotatedWith("app_dir")->toInstance($appDir);

        // install
        $this->install(new Log\MonologModule);
        $this->installCoreModule();
    }

    /**
     * Core Module
     */
    private function installCoreModule()
    {
        $injector = Injector::create([$this]);
        $monologLogger = $injector->getInstance('BEAR\Framework\Module\Log\MonologModule\MonologProvider')->get();
        $logger = $this->requestInjection('BEAR\Framework\Inject\Logger\Adapter');
        $injector->setLogger($logger);
        $config = $injector->getContainer()->getForge()->getConfig();
        $this->bind('Aura\Di\ConfigInterface')->toInstance($config);
        $this->bind('Ray\Di\InjectorInterface')->toInstance($injector);
        $this->bind('BEAR\Resource\ResourceInterface')->to('BEAR\Resource\Resource')->in(Scope::SINGLETON);
        $this->bind('BEAR\Resource\InvokerInterface')->to('BEAR\Resource\Invoker')->in(Scope::SINGLETON);
        $this->bind('BEAR\Resource\LinkerInterface')->to('BEAR\Resource\Linker')->in(Scope::SINGLETON);
        $this->bind('BEAR\Resource\LoggerInterface')->annotatedWith("resource_logger")->to('BEAR\Resource\Logger');
        $this->bind('BEAR\Resource\LoggerInterface')->toProvider('BEAR\Framework\Module\Provider\ResourceLoggerProvider');
        $this->bind('Guzzle\Common\Cache\AbstractCacheAdapter')->toProvider('BEAR\Framework\Module\Provider\ApcCacheProvider')->in(Scope::SINGLETON);
        $this->bind('Aura\Signal\Manager')->toProvider('BEAR\Framework\Module\Provider\SignalProvider')->in(Scope::SINGLETON);
        $this->bind()->annotatedWith('app_name')->toInstance($this->app);
        $this->bind('BEAR\Framework\Web\ResponseInterface')->to('BEAR\Framework\Web\SymfonyResponse');
        $this->bind('BEAR\Framework\Exception\ExceptionHandlerInterface')->to('BEAR\Framework\Exception\ExceptionHandler');
        $this->bind('BEAR\Framework\Output\ConsoleInterface')->to('BEAR\Framework\Output\Console');
        $this->bind('Doctrine\Common\Annotations\Reader')->to('Doctrine\Common\Annotations\AnnotationReader');
        $this->bind('BEAR\Framework\Resource\CacheControl\Taggable')->to('BEAR\Framework\Resource\CacheControl\Etag');
    }
}
