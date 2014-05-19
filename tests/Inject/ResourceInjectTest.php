<?php

namespace BEAR\Sunday\Inject;

use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use BEAR\Sunday\Module\Resource\ResourceModule;

class ResourceApplication
{
    use ResourceInject;

    public function returnDependency()
    {
        return $this->resource;
    }

}

class AppName extends AbstractModule
{
    protected function configure()
    {
        $this->bind()->annotatedWith('app_name')->toInstance('Vendor\App');
    }
}

class ResourceInjectTest extends \PHPUnit_Framework_TestCase
{
    public function testInjectTrait()
    {
        $app = Injector::create([new AppName, new ResourceModule])->getInstance(__NAMESPACE__ . '\ResourceApplication');
        $this->assertInstanceOf('BEAR\Resource\ResourceInterface', $app->returnDependency());
    }
}
