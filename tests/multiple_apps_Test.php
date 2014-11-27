<?php

namespace BEAR\Sunday;

use Ray\Di\Injector;
use BEAR\Resource\ResourceInterface;
use FakeVendor\HelloWorldX\Module\AppModule;
use BEAR\Resource\Request;

class multiple_apps_Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResourceInterface
     */
    private $resource;

    public function setUp()
    {
        $this->resource = (new Injector(new AppModule, $_ENV['TMP_DIR']))->getInstance(ResourceInterface::class);
    }

    public function testMultipleHostInOneApplication()
    {
        $greeting = $this->resource->get->uri('app://self/greeting')->eager->request();
        $this->assertSame('hello world', $greeting->body['hello']);
        $this->assertInstanceOf(Request::class, $greeting->body['hello_rel']);
    }
}
