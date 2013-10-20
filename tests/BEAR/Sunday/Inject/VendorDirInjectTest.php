<?php

namespace BEAR\Sunday\Inject;

use BEAR\Sunday\Module\Constant\NamedModule;
use Ray\Di\Injector;

class VendorDirApplication
{
    use VendorDirInject;

    public function returnDependency()
    {
        return $this->vendorDir;
    }

}

class VendorDirInjectTest extends \PHPUnit_Framework_TestCase
{
    public function testInjectTrait()
    {
        $config = [
            'vendor_dir' => __DIR__
        ];
        $app = Injector::create([new NamedModule($config)])->getInstance(__NAMESPACE__ . '\VendorDirApplication');
        $this->assertSame(__DIR__, $app->returnDependency());
    }
}