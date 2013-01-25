<?php

namespace BEAR\Sunday\Tests;

use BEAR\Sunday\Version;

/**
 * Test class for Annotation.
 */
class FrameworkTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->version = new Version;
    }

    public function test_New()
    {
        $this->assertInstanceOf('BEAR\Sunday\Version', $this->version);
    }
}
