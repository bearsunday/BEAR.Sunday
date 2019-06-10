<?php

declare(strict_types=1);

namespace BEAR\Sunday\Module\Cache;

use Doctrine\Common\Cache\Cache;
use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;

class DoctrineCacheModuleTest extends TestCase
{
    public function testGetInstance()
    {
        $cache = (new Injector(new DoctrineCacheModule))->getInstance(Cache::class);
        $this->assertInstanceOf(Cache::class, $cache);
    }
}
