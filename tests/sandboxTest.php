<?php

namespace BEAR\Framework;

/**
 * Test class for Annotation.
 */
class SandboxTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $app = require dirname(__DIR__) . '/apps/sandbox/scripts/instance.php';
        $this->resource = $app->resource;
    }

    public function test_GetPosts()
    {
        // resource request
        $page = $this->resource->get->uri('page://self/posts')->eager->request();
        $this->assertSame(200, $page->code);
        $this->assertArrayHasKey('posts', $page->body);
        $html = (string)$page;
        $this->assertTrue(is_string($html));
        $this->assertContains('Posts', $html);
    }
}