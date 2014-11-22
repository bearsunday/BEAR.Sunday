<?php

namespace BEAR\Sunday\Module\Cache;

use Doctrine\Common\Cache\Cache;

use Ray\Di\Injector;

class DoctrineCacheModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $cache = (new Injector(new DoctrineCacheModule))->getInstance(Cache::class);
        $this->assertInstanceOf(Cache::class, $cache);
    }
}
