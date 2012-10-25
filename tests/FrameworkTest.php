<?php

namespace BEAR\Sunday\Tests;

use BEAR\Sunday\Framework\Framework;

/**
 * Test class for Annotation.
 */
class FrameworkTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->framework = new Framework;
    }

    public function test_New()
    {
        $this->assertInstanceOf('BEAR\Sunday\Framework\Framework', $this->framework);
    }
}
