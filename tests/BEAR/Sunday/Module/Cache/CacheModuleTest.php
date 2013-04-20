<?php

namespace BEAR\Sunday\Module\Cache;

use BEAR\Sunday\Module\Constant\NamedModule;
use BEAR\Sunday\Module\Resource\ResourceCacheModule;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Guzzle\Cache\CacheAdapterInterface;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;
use BEAR\Sunday\Annotation\Cache;

class CacheModuleTestClass
{
    public $cache;

    /**
     * @param \Guzzle\Cache\AbstractCacheAdapter $cache
     *
     * @Inject
     * @Named("resource_cache")
     */
    public function __construct(CacheAdapterInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @Cache
     */
    public function onGet()
    {
        return rand(0, 100);
    }

}

class CacheModuleTest extends \PHPUnit_Framework_TestCase
{
    private $instance;

    protected function setUp()
    {
        $this->instance = Injector::create(
            [
                new NamedModule(['tmp_dir' => sys_get_temp_dir()]),
                new ResourceCacheModule
            ]
        )->getInstance(__NAMESPACE__ . '\CacheModuleTestClass');
    }

    public function testGetInstance()
    {
        $this->assertInstanceOf('Guzzle\Cache\DoctrineCacheAdapter', $this->instance->cache);
    }
}
