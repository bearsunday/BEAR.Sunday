<?php

namespace BEAR\Sunday\Module\Constant;

use Ray\Di\Injector;
use BEAR\Sunday\FakeApplication;

class ConstantModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FakeApplication
     */
    private $app;

    protected function setUp()
    {
        $names = [
            'path' => __DIR__,
            'id' => 'bear'
        ];
        $this->app = (new Injector(new NamedModule($names)))->getInstance(FakeApplication::class);
    }

    public function testNamed()
    {
        $this->assertSame(__DIR__, $this->app->dir);
        $this->assertSame('bear', $this->app->id);
    }
}
