<?php

namespace demoWorld\Module;

use Ray\Di\AbstractModule,
    Ray\Di\InjectorInterface,
    Ray\Di\Annotation,
    Ray\Di\Config,
    Ray\Di\Forge,
    Ray\Di\Container,
    Ray\Di\Injector,
    Ray\Di\Definition,
    Ray\Di\Scope;

use BEAR\Framework\Module\StandardModule,
    BEAR\Framework\Interceptor\Transactional,
    BEAR\Framework\Interceptor\Cache,
    Doctrine\Common\Cache\MemcacheCache as CacheAdapter;

use \demoWorld\Interceptor\Log;

/**
 * Application default module
 */
class AppModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind('BEAR\Resource\SchemeCollection')->toProvider('\demoWorld\Module\Provider\SchemeCollectionProvider')->in(Scope::SINGLETON);
        $this->bind()->annotatedWith('GreetingMessage')->toInstance(['en' => 'Hello World', 'ja' => 'Konichiwa Sekai']);
        $this->bind()->annotatedWith('Twig')->toProvider('\demoWorld\Module\Provider\TwigProvider');
        $this->bind()->annotatedWith('Smarty')->toProvider('\demoWorld\Module\Provider\SmartyProvider');
        $helloDi = include dirname(dirname(__DIR__)) . '/00-helloworld-min/script/di.php';
        $this->bind('Ray\Di\InjectorInterface')->annotatedWith('HelloDi')->toInstance($helloDi);
        $this->bind()->annotatedWith('dsn')->toInstance('/tmp/demo01.sqlite3');
        // PDO
        $this->bind('Ray\Di\ProviderInterface')->annotatedWith('pdo')->to('\demoWorld\Module\Provider\PdoProvider');
        // Doctrine DBAL
        $this->bind('Doctrine\DBAL\Connection')->annotatedWith('dbal')->toProvider('\demoWorld\Module\Provider\DbalProvider');
        // Annotation
        $this->bindInterceptor($this->matcher->any(), $this->matcher->annotatedWith('Log'), [new Log]);
//         $this->bindInterceptor($this->matcher->any(), $this->matcher->annotatedWith('Transactional'), [new Transactional]);
//         $this->bindInterceptor($this->matcher->any(), $this->matcher->annotatedWith('Cache'), [new Cache(new CacheAdapter, __NAMESPACE__, 2, 'localhost')]);
//         $this->bindInterceptor($this->matcher->any(), $this->matcher->annotatedWith('CacheUpdate'), [new Cache(new CacheAdapter, __NAMESPACE__, 2, 'localhost')]);
    }
}