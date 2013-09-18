<?php

namespace BEAR\Sunday\Inject;

use BEAR\Sunday\Module\Constant\NamedModule;
use Ray\Di\Injector;

class TmpDirApplication
{
    use TmpDirInject;

    public function returnDependency()
    {
        return $this->tmpDir;
    }

}

class TmpDirInjectTest extends \PHPUnit_Framework_TestCase
{
    public function testInjectTrait()
    {
        $config = [
            'tmp_dir' => __DIR__
        ];
        $app = Injector::create([new NamedModule($config)])->getInstance(__NAMESPACE__ . '\TmpDirApplication');
        $this->assertSame(__DIR__, $app->returnDependency());
    }
}