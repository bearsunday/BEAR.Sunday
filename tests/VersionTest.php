<?php

namespace BEAR\Sunday\tests;

use BEAR\Sunday\Version;

/**
 * Test class for Annotation.
 */
class VersionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Version
     */
    private $version;

    protected function setUp()
    {
        parent::setUp();
        $this->version = new Version;
    }

    public function testNew()
    {
        $this->assertInstanceOf('BEAR\Sunday\Version', $this->version);
    }

    public function testVersion()
    {
        $actual = Version::VERSION;
        $this->assertInternalType('string', $actual);
    }
}
