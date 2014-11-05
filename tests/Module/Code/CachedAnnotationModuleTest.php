<?php

namespace BEAR\Sunday\Module\Code;

use BEAR\Sunday\Module\Cache\CacheModule;
use BEAR\Sunday\Module\Constant\NamedModule;
use Ray\Di\Injector;

class CachedAnnotationModuleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $cacheReader = (new Injector(new CacheModule(new CachedAnnotationModule(new NamedModule(['tmp_dir' => $_ENV['TEST_DIR']])))))->getInstance('Doctrine\Common\Annotations\Reader');
        $this->assertInstanceOf('Doctrine\Common\Annotations\CachedReader', $cacheReader);
    }
}
