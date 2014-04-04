<?php

namespace BEAR\Sunday\Module\Resource;

use BEAR\Sunday\Module\Constant\NamedModule;
use BEAR\Sunday\Module\Resource\ResourceCacheModule;
use Guzzle\Cache\CacheAdapterInterface;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

class Application
{
    public $cache;

    /**
     * @Inject
     * @Named("resource_cache")
     */
    public function setCache(CacheAdapterInterface $cache)
    {
        $this->cache = $cache;
    }
}

class ResourceCacheModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testResourceCache()
    {
        $config = [
            'tmp_dir' => $GLOBALS['TEST_TMP']
        ];
        $injector = Injector::create([new NamedModule($config), new ResourceCacheModule]);
        $app = $injector->getInstance(__NAMESPACE__ . '\Application');
        $this->assertInstanceOf('Guzzle\Cache\DoctrineCacheAdapter' , $app->cache);
    }
}
