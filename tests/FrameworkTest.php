<?php

namespace BEAR\Framework\Tests;

use BEAR\Framework\Framework;

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
        $this->assertInstanceOf('BEAR\Framework\Framework', $this->framework);
    }

    /**
     * loader already set, no error triggerd.
     */
    public function test_NewSecond()
    {
        $this->assertInstanceOf('BEAR\Framework\Framework', $this->framework);
    }
}
