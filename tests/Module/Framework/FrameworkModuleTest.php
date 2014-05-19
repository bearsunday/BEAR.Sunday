<?php

namespace BEAR\Sunday\Module\Framework;

use BEAR\Sunday\Module\Constant\NamedModule;
use Ray\Di\Injector;
use Ray\Di\Module\InjectorModule;

class FrameworkModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Ray\Di\Injector
     */
    private $injector;

    protected function setUp()
    {
        $config = [
            'app_name' => 'Vendor\App',
            'tmp_dir'=> $_ENV['TEST_DIR']
        ];
        $modules = [
            new NamedModule($config),
            new FrameworkModule,
            new InjectorModule
        ];
        $this->injector = Injector::create($modules);
    }

    public function testInjector()
    {
        $instance = $this->injector->getInstance('Ray\Di\InjectorInterface');
        $this->assertInstanceOf('Ray\Di\InjectorInterface', $instance);
    }

    public function testResource()
    {
        $instance = $this->injector->getInstance('BEAR\Resource\ResourceInterface');
        $this->assertInstanceOf('BEAR\Resource\Resource', $instance);
    }

}
