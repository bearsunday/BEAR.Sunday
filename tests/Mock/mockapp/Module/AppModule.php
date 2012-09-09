<?php
namespace mockapp\Module;

use Ray\Di\AbstractModule;
use Ray\Di\InjectorInterface as Di;
use Ray\Di\Injector;

// use Guzzle\Common\Cache\DoctrineCacheAdapter as CacheAdapter;
// use Doctrine\Common\Cache\ApcCache as CacheBackEnd;

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
