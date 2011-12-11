<?php

namespace BEAR\Framework;

/**
 * Test class for Annotation.
 */
class App00Test extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->di = require dirname(__DIR__) . '/apps/00-helloworld-min/script/di.php';
    }

    public function testgetDefinitionScope()
    {
        // resource request
        $response = $this->di->getInstance('\BEAR\Resource\Client')->get->uri('page://self/hello')->withQuery(['name' => 'Sunday'])->eager->request();
        $this->assertSame(200, $response->code);
        $this->assertSame('Hello Sunday', $response->body);
    }
}