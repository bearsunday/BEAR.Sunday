<?php

namespace BEAR\Sunday\Module\Constant;

use BEAR\Sunday\Module\Constant\NamedModule;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use Ray\Di\Di\Inject;
use Ray\Di\Di\Named;

class Application
{
    public $dir;
    public $id;

    /**
     * @Inject
     * @Named("path")
     */
    public function setPath($dir)
    {
        $this->dir = $dir;
    }

    /**
     * @Inject
     * @Named("id")
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}

class ConstantModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Application
     */
    private $app;

    protected function setUp()
    {
        $names = [
            'path' => __DIR__,
            'id' => 'bear'
        ];
        $this->app = Injector::create([new NamedModule($names)])->getInstance(__NAMESPACE__ .'\Application');
    }

    public function testNamed()
    {
        $this->assertSame(__DIR__ , $this->app->dir);
        $this->assertSame('bear' , $this->app->id);
    }
}
