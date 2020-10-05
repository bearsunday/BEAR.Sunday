<?php

declare(strict_types=1);

namespace MyVendor\HelloWorld\Resource\Page;

use BEAR\Resource\ResourceInterface;
use MyVendor\HelloWorld\AppModule;
use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;

class IndexTest extends TestCase
{
    /** @var ResourceInterface */
    private $resource;

    protected function setUp(): void
    {
        parent::setUp();
        /** @var ResourceInterface $this->resource */
        $this->resource = (new Injector(new AppModule()))->getInstance(ResourceInterface::class);
    }

    public function testInstance(): void
    {
        $page = $this->resource->newInstance('page://self/');
        $this->assertInstanceOf(Index::class, $page);
    }

    public function testGet(): void
    {
        $page = $this->resource->uri('page://self/')();
        $this->assertInstanceOf(Index::class, $page);
        /** @var Index $page */
        $this->assertSame(200, $page->code);
        $this->assertSame('Hello World', (string) $page->body['greeting']);
        $expectJson = '{
    "greeting": "Hello World"
}
';
        $this->assertSame($expectJson, (string) $page);
    }
}
