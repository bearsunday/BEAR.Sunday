<?php

namespace BEAR\Sunday\Inject;

use BEAR\Sunday\Module\Constant\NamedModule;
use Ray\Di\Injector;

class LibDirApplication
{
    use LibDirInject;

    public function returnDependency()
    {
        return $this->libDir;
    }

}

class LibDirInjectTest extends \PHPUnit_Framework_TestCase
{
    public function testInjectTrait()
    {
        $config = [
            'lib_dir' => __DIR__
        ];
        $app = (new Injector(new NamedModule($config)))->getInstance(__NAMESPACE__ . '\LibDirApplication');
        $this->assertSame(__DIR__, $app->returnDependency());
    }
}
