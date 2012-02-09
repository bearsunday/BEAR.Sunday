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
    
    public function __construct(Inject $injector, $appName){
        $this->injector = $injector;
        $this->appName = $appName;
        parent::__construct();
        $this->configure();
    }

    protected function configure()
    {
        $this->bind()->annotatedWith('AppName')->toInstance($this->appName);
        $this->bind('Ray\Di\InjectorInterface')->toInstance($this->injector);
        $this->bind('Ray\Di\ConfigInterface')->toInstance($this->injector->getContainer()->getForge()->getConfig());
        $this->bind('BEAR\Resource\Resource')->to('BEAR\Resource\Client');
        $this->bind('BEAR\Resource\Invokable')->to('BEAR\Resource\Invoker');
        $this->bind('BEAR\Resource\Linkable')->to('BEAR\Resource\Linker');
    }
}
