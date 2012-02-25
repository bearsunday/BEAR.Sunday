<?php

namespace BEAR\Framework\Module;

use Ray\Di\AbstractModule,
    Ray\Di\InjectorInterface as Inject,
    Ray\Di\Scope;
/**
 * Framework default module
 */
class StandardModule extends AbstractModule
{
    private $injector;
    private $appName;

    public function __construct(Inject $injector, $appName)
    {
        $this->bindings = new \ArrayObject;
        $this->pointcuts = new \ArrayObject;
        $this->container = new \ArrayObject;
        $this->injector = $injector;
        $this->config = $injector->getContainer()->getForge()->getConfig();
        $this->appName = $appName;
        $this->configure();
    }

    protected function configure()
    {
        $this->bind()->annotatedWith('AppName')->toInstance($this->appName);
        $this->bind('Ray\Di\InjectorInterface')->toInstance($this->injector);
        $this->bind('Ray\Di\ConfigInterface')->toInstance($this->config);
        $this->bind('BEAR\Resource\Resource')->to('BEAR\Resource\Client')->in(Scope::SINGLETON);
        $this->bind('BEAR\Resource\Invokable')->to('BEAR\Resource\Invoker')->in(Scope::SINGLETON);
        $this->bind('BEAR\Resource\Linkable')->to('BEAR\Resource\Linker')->in(Scope::SINGLETON);
        $this->bind('Guzzle\Common\Cache\AbstractCacheAdapter')->toProvider('BEAR\Framework\Module\Provider\CacheProvider')->in(Scope::SINGLETON);
        $this->bind('Aura\Signal\Manager')->toProvider('BEAR\Framework\Module\Provider\SignalProvider')->in(Scope::SINGLETON);
    }
}
