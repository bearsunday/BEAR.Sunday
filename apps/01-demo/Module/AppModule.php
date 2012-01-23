<?php

namespace demoWorld\Module;

use Ray\Di\AbstractModule,
    Ray\Di\InjectorInterface;
use BEAR\Framework\Interceptor\Transactional;

/**
 * Application default module
 */
class AppModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind()->annotatedWith('AppName')->toInstance('demoWorld');
        $this->bind('BEAR\Resource\SchemeCollection')->toProvider('\demoWorld\Module\SchemeCollectionProvider');
        $this->bind()->annotatedWith('GreetingMessage')->toInstance(['en' => 'Hello World', 'ja' => 'Konichiwa Sekai']);
        $this->bind()->annotatedWith('Twig')->toProvider('\demoWorld\Module\TwigProvider');
        $this->bind()->annotatedWith('Smarty')->toProvider('\demoWorld\Module\SmartyProvider');
        $interceptors = array(new \demoWorld\Interceptor\Log);
        $this->registerInterceptAnnotation('Log', $interceptors);
        $helloDi = include dirname(dirname(__DIR__)) . '/00-helloworld-min/script/di.php';
        $this->bind('Ray\Di\InjectorInterface')->annotatedWith('HelloDi')->toInstance($helloDi);
        // PDO
        $this->bind('Ray\Di\ProviderInterface')->annotatedWith('user_db')->to('\demoWorld\Module\PdoProvider');
        $this->registerInterceptAnnotation('Transactional', array(new Transactional));
    }
}