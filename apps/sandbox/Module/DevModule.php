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
use BEAR\Framework\Module\StandardModule;
use BEAR\Framework\Module\TemplateEngine;
use BEAR\Framework\Module\Database;
use helloworld\Module\AppModule as HelloWorldModule;
use Ray\Di\Scope;
use Ray\Di\AbstractModule;

use BEAR\Framework\Interceptor\Stab;

/**
 * Application module
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
     * Constructor
     *
     * @param string $app
     */
    public function __construct($app)
    {
        $this->app = $app;
        parent::__construct();
    }

    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        // install framework module
        $tmpDir = dirname(__DIR__) . '/tmp';
        $logDir = dirname(__DIR__) . '/log';
        $this->bind('BEAR\Resource\Invokable')->to('BEAR\Resource\DevInvoker')->in(Scope::SINGLETON);
        $this->install(new FrameworkModule($this->app, $tmpDir, $logDir));

        // install dev module
        $this->install(new TemplateEngine\DevRendererModule);
        
        // install application module
        $this->install(new AppModule($this));

        // indtall runmode module
        $masterDb = $slaveDb = [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'blogbear',
            'user' => 'root',
            'password' => null,
            'charset' => 'UTF8'
        ];
        $this->install(new Database\DoctrineDbalModule($masterDb, $slaveDb));

        // log all resource access
        $logger = $this->requestInjection('BEAR\Framework\Interceptor\Logger');
        $this->bindInterceptor(
            $this->matcher->subclassesOf('BEAR\Resource\Object'),
            $this->matcher->startWith('on'),
            [$logger]
        );

        // dev invoker
    }
}
