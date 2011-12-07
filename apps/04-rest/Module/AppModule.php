<?php

namespace restWorld\Module;

use Ray\Di\AbstractModule,
    Ray\Di\InjectorInterface;

/**
 * Application default module
 */
class AppModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind()->annotatedWith('ResourceAdapters')->toProvider('\restWorld\Module\ResourceAdapterProvider');
        $this->bind()->annotatedWith('GreetingMessage')->toInstance(['en' => 'Hello World', 'ja' => 'Konichiwa Sekai']);
        $this->bind()->annotatedWith('Twig')->toProvider('\restWorld\Module\TwigProvider');
        $this->bind()->annotatedWith('Smarty')->toProvider('\restWorld\Module\SmartyProvider');
        $interceptors = array(new \restWorld\Interceptor\Log);
        $this->registerInterceptAnnotation('Log', $interceptors);
    }
}