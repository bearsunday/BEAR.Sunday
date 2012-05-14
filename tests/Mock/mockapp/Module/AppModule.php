<?php
namespace mockapp\Module;

use Ray\Di\AbstractModule,
    Ray\Di\InjectorInterface as Di,
    Ray\Di\Annotation,
    Ray\Di\Config,
    Ray\Di\Forge,
    Ray\Di\Container,
    Ray\Di\Injector,
    Ray\Di\Definition,
    Ray\Di\Scope;

use BEAR\Framework\Module\StandardModule,
BEAR\Framework\Interceptor\Transactional,
BEAR\Framework\Interceptor\CacheLoader as CacheLoadInterceptor,
BEAR\Framework\Interceptor\CacheUpdater as CacheUpdateInterceptor;

use \demoworld\Interceptor\Log;

// use Guzzle\Common\Cache\DoctrineCacheAdapter as CacheAdapter;
// use Doctrine\Common\Cache\ApcCache as CacheBackEnd;

use Guzzle\Common\Cache\Zf2CacheAdapter as CacheAdapter;;
use Zend\Cache\Backend\File as CacheBackEnd;

/**
 * Application default module
 */
class AppModule extends AbstractModule
{
    public function __construct(Di $injector)
    {
        $this->injector = $injector;
        parent::__construct();
    }

    /**
     * Binding configuration
     *
     * @return void
     */
    protected function configure()
    {
    }
}