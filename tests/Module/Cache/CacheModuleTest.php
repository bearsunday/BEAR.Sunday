<?php

namespace BEAR\Sunday\Module\Cache;

use BEAR\Sunday\Module\Constant\NamedModule;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Guzzle\Cache\AbstractCacheAdapter;
use Ray\Di\Di\Inject;

class Application
{
    public $cache;

    /**
     * @Inject
     */
    public function setCache(AbstractCacheAdapter $cache)
    {
        $this->cache = $cache;
    }
}

class CacheModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testCacheApc()
    {
        $config = [
            'tmp_dir' => $GLOBALS['TEST_TMP']
        ];
        $app = Injector::create([new NamedModule($config), new CacheModule])->getInstance(__NAMESPACE__ . '\Application');
        $this->assertInstanceOf('Guzzle\Cache\DoctrineCacheAdapter' , $app->cache);
    }
}