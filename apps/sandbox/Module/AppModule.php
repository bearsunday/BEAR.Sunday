<?php
/**
 * Module
 *
 * @package    sandbox
 * @subpackage Module
 */
namespace sandbox\Module;

use Ray\Di\Scope;

use BEAR\Framework\Module\StandardModule;
use BEAR\Framework\Interceptor\DbInjector;
use BEAR\Framework\Interceptor\CacheLoader as CacheLoadInterceptor;
use BEAR\Framework\Interceptor\CacheUpdater as CacheUpdateInterceptor;

use Ray\Di\AbstractModule;
use Ray\Di\InjectorInterface,
Ray\Di\Annotation,
Ray\Di\Config,
Ray\Di\Forge,
Ray\Di\Container,
Ray\Di\Injector as Di,
Ray\Di\Definition;
use Guzzle\Common\Cache\ZendCacheAdapter as CacheAdapter;;
use Zend\Cache\Backend\File as CacheBackEnd;

/**
 * Application module
 *
 * @package    sandbox
 * @subpackage Module
 */
class AppModule extends AbstractModule
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Configure dependency binding
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind()->annotatedWith('Twig')->toProvider('\BEAR\Framework\Module\Provider\TwigProvider')->in(Scope::SINGLETON);
        $this->bind('Doctrine\DBAL\Connection')->toProvider('\sandbox\Module\Provider\DbalProvider')->in(Scope::SINGLETON);;
        $this->bind('BEAR\Resource\SchemeCollection')->toProvider('\sandbox\Module\SchemeCollectionProvider')->in(Scope::SINGLETON);
        $this->bind()->annotatedWith('master_db')->toInstance(['driver' => 'pdo_mysql', 'host' => 'localhost', 'dbname' => 'blogbear', 'user' => 'root', 'password' => null, 'charset' => 'UTF8']);
        $this->bind()->annotatedWith('slave_db')->toInstance(['driver' => 'pdo_mysql', 'host' => 'localhost', 'dbname' => 'blogbear', 'user' => 'root', 'password' => null, 'charset' => 'UTF8']);
        $this->bind()->annotatedWith('Smarty')->toProvider('\BEAR\Framework\Module\Provider\SmartyProvider')->in(Scope::SINGLETON);;
        $dbInjector = $this->requestInjection('\BEAR\Framework\Interceptor\DbInjector');
        $this->bindInterceptor(
                $this->matcher->annotatedWith('BEAR\Framework\Annotation\Db'),
                $this->matcher->any(),
                [$dbInjector]
        );
        $cacheLoadInterceptor = new CacheLoadInterceptor(new CacheAdapter(new CacheBackEnd));
        $this->bindInterceptor(
                $this->matcher->any(),
                $this->matcher->annotatedWith('BEAR\Framework\Annotation\Cache'),
                [$cacheLoadInterceptor]
        );
    }
}