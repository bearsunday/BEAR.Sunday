<?php
namespace demoworld\Module;

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
    BEAR\Framework\Interceptor\Cache as CacheInterceptor;

use \demoworld\Interceptor\Log;

// use Guzzle\Common\Cache\DoctrineCacheAdapter as CacheAdapter;
// use Doctrine\Common\Cache\ApcCache as CacheBackEnd;

use Guzzle\Common\Cache\ZendCacheAdapter as CacheAdapter;;
use Zend\Cache\Backend\File as CacheBackEnd;

/**
 * Application default module
 */
class AppModule extends AbstractModule
{
    /**
     * Binding configuration
     *
     * @return void
     */
    protected function configure()
    {
        $this->bind('BEAR\Resource\SchemeCollection')->toProvider('\demoworld\Module\Provider\SchemeCollectionProvider')->in(Scope::SINGLETON);
        $this->bind()->annotatedWith('GreetingMessage')->toInstance(['en' => 'Hello World', 'ja' => 'Konichiwa Sekai']);
        $this->bind()->annotatedWith('Twig')->toProvider('\demoworld\Module\Provider\TwigProvider')->in(Scope::SINGLETON);;
        $this->bind()->annotatedWith('Smarty')->toProvider('\demoworld\Module\Provider\SmartyProvider')->in(Scope::SINGLETON);;
        $helloDi = include dirname(dirname(__DIR__)) . '/helloworld/scripts/di.php';
        $this->bind('Ray\Di\InjectorInterface')->annotatedWith('HelloDi')->toInstance($helloDi);
        $this->bind()->annotatedWith('dsn')->toInstance('/tmp/demo01.sqlite3');
        // PDO
        $this->bind('Ray\Di\ProviderInterface')->annotatedWith('pdo')->to('\demoworld\Module\Provider\PdoProvider')->in(Scope::SINGLETON);;
        // Doctrine DBAL
        $this->bind('Doctrine\DBAL\Connection')->annotatedWith('dbal')->toProvider('\demoworld\Module\Provider\DbalProvider')->in(Scope::SINGLETON);;
        // Web context
        $this->bind('Ray\Di\ProviderInterface')->annotatedWith('webContext')->to('\demoworld\Module\Provider\WebContextProvider')->in(Scope::SINGLETON);;
        // Annotation
        $this->bindInterceptor($this->matcher->any(), $this->matcher->annotatedWith('\demoworld\Interceptor\Log'), [new Log]);
//         $this->bindInterceptor($this->matcher->any(), $this->matcher->annotatedWith('Transactional'), [new Transactional]);
        $this->bindInterceptor($this->matcher->any(), $this->matcher->annotatedWith('demoworld\Annotation\Cache'), [new CacheInterceptor(new CacheAdapter(new CacheBackEnd))]);
//         $this->bindInterceptor($this->matcher->any(), $this->matcher->annotatedWith('CacheUpdate'), [new Cache(new CacheAdapter, __NAMESPACE__, 2, 'localhost')]);
    }
}