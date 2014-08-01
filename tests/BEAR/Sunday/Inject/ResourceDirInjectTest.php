<?php

namespace BEAR\Sunday\Inject;

use Ray\Di\Injector;
use BEAR\Sunday\Module\Constant\NamedModule;

class ResourceDirApplication
{
    use ResourceDirInject;

    public function returnDependency()
    {
        return $this->resourceDir;
    }

}

class ResourceDirInjectTest extends \PHPUnit_Framework_TestCase
{
    public function testInjectTrait()
    {
        $config = [
            'resource_dir' => __DIR__ . '/src/Resource'
        ];
        $app = Injector::create([new NamedModule($config)])->getInstance(__NAMESPACE__ . '\ResourceDirApplication');
        $this->assertSame( __DIR__ . '/src/Resource', $app->returnDependency());
    }
}
