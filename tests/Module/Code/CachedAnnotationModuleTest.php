<?php

namespace BEAR\Sunday\Module\Code;

use BEAR\Sunday\Module\Cache\CacheModule;
use BEAR\Sunday\Module\Constant\NamedModule;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;

class CachedAnnotationModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $modules = [
            new NamedModule(['tmp_dir' => $_ENV['TEST_DIR']]),
            new CacheModule(),
            new CachedAnnotationModule
        ];
        $cacheReader = Injector::create($modules)->getInstance('Doctrine\Common\Annotations\Reader');
        $this->assertInstanceOf('Doctrine\Common\Annotations\CachedReader', $cacheReader);
    }
}
