<?php

namespace MyVendor\HelloWorld\Resource\Page;

use BEAR\Resource\ResourceInterface;
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Extension\Application\AppInterface;
use MyVendor\HelloWorld\AppModule;
use Ray\Di\Injector;

class IndexTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResourceInterface
     */
    private $resource;

    public function setUp()
    {
        parent::setUp();
        $this->resource = (new Injector(new AppModule))->getInstance(ResourceInterface::class);
    }

    public function testInstance()
    {
        $page = $this->resource->newInstance('page://self/');
    }

    public function testGet()
    {
        $page = $this->resource->get->uri('page://self/')->eager->request();
        $this->assertInstanceOf(Index::class, $page);
        /* @var $page Index */
        $this->assertSame(200, $page->code);
        $expect = 'Hello World';
        $this->assertSame($expect, $page->body['greeting']);
    }
}
