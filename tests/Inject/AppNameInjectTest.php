<?php

namespace BEAR\Sunday\Inject;

use BEAR\Sunday\Module\Constant\NamedModule;
use Ray\Di\Injector;

class AppNameApplication
{
    use AppNameInject;

    public function returnDependency()
    {
        return $this->appName;
    }

}

class AppNameInjectTest extends \PHPUnit_Framework_TestCase
{
    public function testInjectTrait()
    {
        $config = [
            'app_name' => __NAMESPACE__
        ];
        $app = Injector::create([new NamedModule($config)])->getInstance(__NAMESPACE__ . '\AppNameApplication');
        $this->assertSame(__NAMESPACE__, $app->returnDependency());
    }
}
