<?php

declare(strict_types=1);

namespace MyVendor\HelloWorld\Resource\Page;

use BEAR\Resource\ResourceInterface;
use MyVendor\HelloWorld\AppModule;
use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;

class IndexTest extends TestCase
{
    /**
     * @var ResourceInterface
     */
    private $resource;

    protected function setUp()
    {
        parent::setUp();
        $this->resource = (new Injector(new AppModule))->getInstance(ResourceInterface::class);
    }

    public function testInstance()
    {
        $page = $this->resource->newInstance('page://self/');
        $this->assertInstanceOf(Index::class, $page);
    }

    public function testGet()
    {
        $page = $this->resource->uri('page://self/')();
        $this->assertInstanceOf(Index::class, $page);
        /* @var $page Index */
        $this->assertSame(200, $page->code);
        $this->assertSame('Hello World', $page->body['greeting']);
        $expectJson = '{
    "greeting": "Hello World"
}
';
        $this->assertSame($expectJson, (string) $page);
    }
}
