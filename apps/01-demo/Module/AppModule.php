<?php

namespace demoWorld\Module;

use Ray\Di\AbstractModule,
    Ray\Di\InjectorInterface;
use BEAR\Framework\Interceptor\Transactional,
    BEAR\Framework\Interceptor\Cacheable;
use Doctrine\Common\Cache\Cache,
    Doctrine\Common\Cache\MemcacheCache as CacheAdapter;
/**
 * Application default module
 */
class AppModule extends AbstractModule
{
    protected function configure()
    {
        $appName = 'demoWorld';
        $this->bind()->annotatedWith('AppName')->toInstance($appName);
        $this->bind('BEAR\Resource\SchemeCollection')->toProvider('\demoWorld\Module\Provider\SchemeCollectionProvider');
        $this->bind()->annotatedWith('GreetingMessage')->toInstance(['en' => 'Hello World', 'ja' => 'Konichiwa Sekai']);
        $this->bind()->annotatedWith('Twig')->toProvider('\demoWorld\Module\Provider\TwigProvider');
        $this->bind()->annotatedWith('Smarty')->toProvider('\demoWorld\Module\Provider\SmartyProvider');
        $interceptors = [new \demoWorld\Interceptor\Log];
        $this->registerInterceptAnnotation('Log', $interceptors);
        $helloDi = include dirname(dirname(__DIR__)) . '/00-helloworld-min/script/di.php';
        $this->bind('Ray\Di\InjectorInterface')->annotatedWith('HelloDi')->toInstance($helloDi);
        $this->bind()->annotatedWith('dsn')->toInstance('/tmp/demo01.sqlite3');
        // PDO
        $this->bind('Ray\Di\ProviderInterface')->annotatedWith('pdo')->to('\demoWorld\Module\Provider\PdoProvider');
        // Doctrine DBAL
        $this->bind('Doctrine\DBAL\Connection')->annotatedWith('dbal')->toProvider('\demoWorld\Module\Provider\DbalProvider');
        // Annotation
        $this->registerInterceptAnnotation('Transactional', [new Transactional]);
        $this->registerInterceptAnnotation('Cacheable', [new Cacheable(new CacheAdapter, $appName, 2, 'localhost')]);
    }
}