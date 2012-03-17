<?php
namespace demoworld\Module;

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

use Guzzle\Common\Cache\ZendCacheAdapter as CacheAdapter;;
use Zend\Cache\Backend\File as CacheBackEnd;

/**
 * Application default module
 */
class AppModule extends AbstractModule
{
    public function __construct()
    {
        parent::__construct();
    }

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
        // AOP
        $this->bindInterceptor(
                $this->matcher->any(),
                $this->matcher->annotatedWith('\demoworld\Interceptor\Log'),
                [new Log]
        );
        $cacheLoadInterceptor = new CacheLoadInterceptor(new CacheAdapter(new CacheBackEnd));
        $this->bindInterceptor(
                $this->matcher->any(),
                $this->matcher->annotatedWith('BEAR\Framework\Annotation\Cache'),
                [$cacheLoadInterceptor]
        );
        $cacheUpdateInterceptor = Injector::create()->getInstance('BEAR\Framework\Interceptor\CacheUpdater', ['cache' => $cacheLoadInterceptor]);
        $this->bindInterceptor(
                $this->matcher->any(),
                $this->matcher->annotatedWith('BEAR\Framework\Annotation\CacheUpdate'),
                [$cacheUpdateInterceptor]
        );
//         $this->bindInterceptor(
//                 $this->matcher->any(),
//                 $this->matcher->annotatedWith('Transactional'),
//                 [new Transactional]
//         );
     }
}