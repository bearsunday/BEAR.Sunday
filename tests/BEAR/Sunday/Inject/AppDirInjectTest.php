<?php

namespace BEAR\Sunday\Inject;

use BEAR\Sunday\Module\Constant\NamedModule;
use Ray\Di\Injector;

class AppDirApplication
{
    use AppDirInject;

    public function returnDependency()
    {
        return $this->appDir;
    }

}

class AppDirInjectTest extends \PHPUnit_Framework_TestCase
{
    public function testInjectTrait()
    {
        $config = [
            'app_dir' => __DIR__
        ];
        $app = Injector::create([new NamedModule($config)])->getInstance(__NAMESPACE__ . '\AppDirApplication');
        $this->assertSame(__DIR__, $app->returnDependency());
    }
}