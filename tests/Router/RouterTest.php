<?php

namespace BEAR\Framework\Tests;

use BEAR\Framework\Router\Router;

/**
 * Test class for Pager.
 */
class RouterTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->router = new Router;
    }

    public function test_New()
    {
        $this->assertInstanceOf('BEAR\Framework\Router\Router', $this->router);
    }
}
