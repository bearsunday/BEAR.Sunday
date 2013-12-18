<?php

namespace BEAR\Sunday\Module\Resource;

use BEAR\Sunday\Module\Resource\ResourceModule;
use Doctrine\Common\Annotations\AnnotationReader as Reader;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\Di\Module\InjectorModule;

class AppNameModule extends AbstractModule
{
    protected function configure()
    {
        $this->bind()->annotatedWith('app_name')->toInstance('Vendor\App');
    }
}

class ResourceModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BEAR\Resource\Resource
     */
    private $resource;

    protected function setUp()
    {
        $this->resource = Injector::create([new AppNameModule, new InjectorModule(new ResourceModule)])->getInstance('BEAR\Resource\ResourceInterface');
    }

    public function testGetInstance()
    {
        $this->assertInstanceOf('BEAR\Resource\ResourceInterface', $this->resource);
    }
}
