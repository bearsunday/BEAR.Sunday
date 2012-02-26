<?php
namespace demoworld;

use BEAR\Framework\Module\StandardModule;

use Ray\Di\AbstractModule,
    Ray\Di\InjectorInterface,
    Ray\Di\Annotation,
    Ray\Di\Config,
    Ray\Di\Forge,
    Ray\Di\Container,
    Ray\Di\Injector,
    Ray\Di\Definition;
use BEAR\Resource\SignalHandler\Provides;
// Cache Adapter

use Guzzle\Common\Cache\DoctrineCacheAdapter as CacheAdapter;

/**
 * Return application dependency injector.
 *
 * @package    demoworld
 * @subpackage script
 *
 * @return BEAR\Resource\Client
 */

// use Doctrine\Common\Cache\MemcacheCache as CacheBackEnd;
// $mem = new \Memcache;
// $mem->addServer('localhost');
// $memcache = new CacheBackEnd;
// $memcache->setMemcache($mem);
// $cache = new CacheAdapter($memcache);

use Doctrine\Common\Cache\ApcCache as CacheBackEnd;
$cache = new CacheAdapter(new CacheBackEnd);

$resourceClientBuilder = function () use ($cache) {
    $annotations = [
        'provides' => 'BEAR\Resource\Annotation\Provides',
        'signal' => 'BEAR\Resource\Annotation\Signal',
        'argsignal' => 'BEAR\Resource\Annotation\ParamSignal',
        'get' => 'BEAR\Resource\Annotation\Get',
        'post' => 'BEAR\Resource\Annotation\Post',
        'put' => 'BEAR\Resource\Annotation\Put',
        'delete' => 'BEAR\Resource\Annotation\Delete',
        ];
    $di = new Injector(new Container(new Forge(new Config(new Annotation(new Definition, $annotations), $cache))));
    $di->setModule(new Module\AppModule(new StandardModule($di, new App)));
    $resource = $di->getInstance('BEAR\Resource\Client');
    /* @var $resource \BEAR\Resoure\Client */
    $resource->attachParamProvider('Provides', new Provides);
    $resource->setCacheAdapter($cache);
    return $resource;
};

$key = __NAMESPACE__ . __FILE__;
$resource = $cache->fetch($key);
if ($resource) {
    return $resource;
}
$resource = $resourceClientBuilder();
$cache->save($key, $resource);
return $resource;
