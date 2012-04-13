<?php
/**
 * Module
 *
 * @package    sandbox
 * @subpackage Module
 */
namespace sandbox\Module;

use helloworld\Module\AppModule;

use BEAR\Framework\Module\TemplateEngine\SmartyModule;

use Ray\Di\Scope;

use BEAR\Framework\Module\StandardModule;
use BEAR\Framework\Module;
use BEAR\Framework\Module\Extension;
use BEAR\Framework\Interceptor\DbInjector;
use BEAR\Framework\Interceptor\ViewAdapter;
use BEAR\Framework\Interceptor\ViewAdapter\SmartyBackend;
use Ray\Di\AbstractModule;
use Ray\Di\InjectorInterface;
use Ray\Di\Annotation;
use Ray\Di\Config;
use Ray\Di\Forge;
use Ray\Di\Container;
use Ray\Di\Injector as Di;
use Ray\Di\Definition;
use Ray\Di\Injector;
use Guzzle\Common\Cache\ZendCacheAdapter as CacheAdapter;
use Zend\Cache\Backend\File as CacheBackEnd;
use Smarty;
use ReflectionClass;

/**
 * Application module
 *
 * @package    sandbox
 * @subpackage Module
 */
class DevModule extends AbstractModule
{
    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        // application config
        $masterDb = $slaveDb = [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'blogbear',
            'user' => 'root',
            'password' => null,
            'charset' => 'UTF8'
        ];
        $tmpDir = dirname(__DIR__) . '/tmp';

        $this->bind()->annotatedWith('master_db')->toInstance($masterDb);
        $this->bind()->annotatedWith('slave_db')->toInstance($slaveDb);
        $this->bind()->annotatedWith("tmp_dir")->toInstance($tmpDir);
        // install enviroment-depend module
        $this->installWritableChecker();
    }

    /**
     * installWritableChecker
     */
    private function installWritableChecker()
    {
        // bind tmp writable checker
        $checker = $this->requestInjection('\sandbox\Interceptor\Checker');
        $this->bindInterceptor(
            $this->matcher->subclassesOf('sandbox\Resource\Page\Index'),
            $this->matcher->any(),
            [$checker]
        );
    }
}