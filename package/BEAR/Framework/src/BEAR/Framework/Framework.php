<?php
/**
 *  BEAR.Framework
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace BEAR\Framework;

use Aura\Autoload\Loader;
use BEAR\Framework\AbstractAppContext;
use BEAR\Framework\Module\StandardModule;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Ray\Di\AbstractModule,
    Ray\Di\InjectorInterface,
    Ray\Di\Annotation,
    Ray\Di\Config,
    Ray\Di\ApcConfig,
    Ray\Di\Forge,
    Ray\Di\Container,
    Ray\Di\Injector,
    Ray\Di\ApcInjector,
    Ray\Di\Definition;
use BEAR\Resource\SignalHandler\Provides;
use Guzzle\Common\Cache\CacheAdapterInterface as Cache;
use Guzzle\Common\Cache\ZendCacheAdapter as CacheAdapter;;
use Zend\Cache\Backend\File as CacheBackEnd;
/**
 * Globals
 *
 * Emulates web $GLOBALS in CLI
 *
 * @package BEAR.Framework
 * @author  Akihito Koriyama <akihito.koriyama@gmail.com>
 */
class Framework
{
    /**
     * BEAR.Sunday
     *
     * Framework version identification
     */
    const VERSION = '0.1.0';

    /**
     * Resource client
     *
     * @var Client
     */
    private $resource;

    /**
     * App
     *
     * @var AbstractAppContext
     */
    private $app;

    /**
     *
     * System path
     *
     * @var string
     */
    private $system;

    /**
     *
     * Cache
     *
     * @var Cache
     */
    private $cache;

    /**
     * Constructor
     *
     * @param array $argv
     */
    public function __construct()
    {
        $this->system = dirname(dirname(dirname(dirname(dirname(dirname(__DIR__))))));

    }

    /**
     * Set cache backend
     *
     * @param Cache $cache
     *
     * @return \BEAR\Framework\Framework
     */
    public function setCache(Cache $cache = null)
    {
        $this->cache = $cache ?: new CacheAdapter(new CacheBackEnd);
        return $this;
    }

    /**
     * Set standard expection handler
     *
     * @return void
     */
    public function setExceptionHandler()
    {
        require dirname(dirname(dirname(__DIR__))) . '/scripts/exception_handler/standard.php';
        return $this;
    }

    /**
     * Load src
     *
     * @return void
     */
    public function setLoader($appName, $appDir, array $namespaces = [])
    {
        if (class_exists('\Aura\Autoload\Loader', false) === true) {
            return $this;
        }
//         include $this->system . '/package/BEAR/Framework/scripts/core_loader.php';
        require $this->system . '/vendor/.composer/autoload.php';
        $loader = require  $this->system . '/vendor/Aura/Autoload/scripts/instance.php';
        $silentLoader = clone $loader;
        $namespacesBase = require  $this->system . '/vendor' . DIRECTORY_SEPARATOR . '.composer/autoload_namespaces.php';
        $namespacesBase += [
            $appName  => dirname($appDir),
            'BEAR\Framework' => $this->system . '/package/BEAR/Framework/src/'
        ];
        $namespacesBase += $namespaces;
        $loader->setPaths($namespacesBase);
        $loader->register();
        AnnotationRegistry::registerAutoloadNamespace('Ray\Di\Di\\', $this->system . '/vendor/Ray/Di/src/');
        AnnotationRegistry::registerAutoloadNamespace('BEAR\Resource\Annotation\\', $this->system . '/vendor/BEAR/Resource/src/');
        AnnotationRegistry::registerAutoloadNamespace('BEAR\Framework\Annotation\\', $this->system . '/package/BEAR/Framework/src/');
        AnnotationRegistry::registerAutoloadNamespace($appName . '\Annotation', dirname($appDir));
        return $this;
    }

    /**
     * Return resource client;
     *
     * @param unknown_type $key
     * @return \BEAR\Resoure\Client
     */
    public function getResource(array $appModules, AbstractAppContext $app)
    {
        $key = __METHOD__;
        if ($this->cache) {
            $client = $this->cache->fetch($key);
            if ($client) {
                return unserialize($client);
            }
            $client = $this->buildResourceClient($appModules);
            $this->cache->save($key, serialize($client));
            return $client;
        }
        return $this->buildResourceClient($appModules, $app);
    }

    /**
     * Build resource client
     *
     * @return BEAR\Resource\Clinet
     */
    private function buildResourceClient(array $appModules, AbstractAppContext $app)
    {
        $annotations = [
            'provides' => 'BEAR\Resource\Annotation\Provides',
            'signal' => 'BEAR\Resource\Annotation\Signal',
            'argsignal' => 'BEAR\Resource\Annotation\ParamSignal',
            'get' => 'BEAR\Resource\Annotation\Get',
            'post' => 'BEAR\Resource\Annotation\Post',
            'put' => 'BEAR\Resource\Annotation\Put',
            'delete' => 'BEAR\Resource\Annotation\Delete',
        ];
        $this->di = $di = Injector::create();
        $module = new StandardModule($di, $app);
        $di->setModule($module);
        foreach ($appModules as $appModule) {
            $module->install($appModule);
        }
        $di->setModule($module);
        $resource = $di->getInstance('BEAR\Resource\Client');
        /* @var $resource \BEAR\Resoure\Client */
        $resource->attachParamProvider('Provides', new Provides);
        if ($this->cache instanceof Cache) {
            $resource->setCacheAdapter($this->cache);
        }
        $app->resource = $resource;
        return $resource;
    }
}
