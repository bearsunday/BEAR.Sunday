<?php

namespace BEAR\Sunday\Inject;

use Ray\Di\Injector;
use BEAR\Sunday\Module\Constant\NamedModule;

class LogDirApplication
{
    use LogDirInject;

    public function returnDependency()
    {
        return $this->logDir;
    }

}

class LogDirInjectTest extends \PHPUnit_Framework_TestCase
{
    public function testInjectTrait()
    {
        $config = [
            'log_dir' => __DIR__ . '/log'
        ];
        $app = Injector::create([new NamedModule($config)])->getInstance(__NAMESPACE__ . '\LogDirApplication');
        $this->assertSame( __DIR__ . '/log', $app->returnDependency());
    }
}