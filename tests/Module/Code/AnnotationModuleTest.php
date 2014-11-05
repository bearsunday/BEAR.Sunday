<?php

namespace BEAR\Sunday\Module\Code;

use BEAR\Sunday\Module\Code\AnnotationModule;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;

class AnnotationModuleTest extends \PHPUnit_Framework_TestCase
{
    private $instance;

    protected function setUp()
    {
        $this->instance = (new Injector(new AnnotationModule))->getInstance('Doctrine\Common\Annotations\Reader');
    }

    public function testGetInstance()
    {
        $this->assertInstanceOf('Doctrine\Common\Annotations\AnnotationReader', $this->instance);
    }
}
