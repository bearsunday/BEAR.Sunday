<?php

namespace BEAR\Sunday\Module\Resource;

use BEAR\Resource\SchemeCollection;
use BEAR\Sunday\Module\Code\AnnotationModule;
use BEAR\Sunday\Module\Di\InjectorModule;
use BEAR\Sunday\Module\Resource\ResourceModule;
use BEAR\Sunday\Module\SchemeModule;
use Doctrine\Common\Annotations\AnnotationReader as Reader;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\Di\ProviderInterface;

class TestScheme implements ProviderInterface
{
    public function get()
    {
        return new SchemeCollection;
    }
}

class ResourceModuleTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->resource = Injector::create(
            [
                new AnnotationModule,
                new InjectorModule,
                new ResourceModule,
                new SchemeModule(__NAMESPACE__ . '\TestScheme')
            ]
        )->getInstance('BEAR\Resource\Resource');
    }

    public function testGetInstance()
    {
        $this->assertInstanceOf('BEAR\Resource\Resource', $this->resource);
    }
}
