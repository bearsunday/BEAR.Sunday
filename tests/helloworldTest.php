<?php

namespace BEAR\Framework;

/**
 * Test class for Annotation.
 */
class HelloworldTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        apc_clear_cache("user");
        $app = require dirname(__DIR__) . '/apps/helloworld/scripts/instance.php';
        $this->resource = $app->resource;
    }

    public function testPage()
    {
        // resource request
        $response = $this->resource->get->uri('page://self/hello')->withQuery(['name' => 'Sunday'])->eager->request();
        $this->assertSame(200, $response->code);
        $this->assertSame('Hello Sunday', $response->body);
    }
}