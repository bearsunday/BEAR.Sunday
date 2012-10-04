<?php

namespace BEAR\Framework\Tests;

use BEAR\Framework\Framework\Framework;

/**
 * Test class for Annotation.
 */
class CliTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->systemRoot = dirname(__DIR__);
    }

    public function test_devWebPhp()
    {
        $cli = 'php ' . $this->systemRoot . '/apps/Sandbox/htdocs/web.php get /index';
        exec($cli, $return);
        $pos = $this->assertContains('<!DOCTYPE html>', $return);
    }

    public function test_devApiPhp()
    {
        $cli = 'php ' . $this->systemRoot . '/apps/Sandbox/htdocs/api.php get page://self/index';
        exec($cli, $return);
        $html = implode('', $return);
        $pos = strpos($html, 'Hello, BEAR.Sunday');
        $this->assertTrue(is_int($pos), implode($return, "\n"));
    }

    public function test_devApiPhpRep()
    {
        $cli = 'php ' . $this->systemRoot . '/apps/Sandbox/htdocs/api.php get page://self/index view';
        exec($cli, $return);
        $html = implode('', $return);
        $pos = strpos($html, 'Hello, BEAR.Sunday');
        $this->assertTrue(is_int($pos));
    }

    public function test_devApiPhpValue()
    {
        $cli = 'php ' . $this->systemRoot . '/apps/Sandbox/htdocs/api.php get page://self/index value';
        exec($cli, $return);
        $html = implode('', $return);
        $pos = strpos($html, 'Hello, BEAR.Sunday');
        $this->assertTrue(is_int($pos));
    }

    public function test_devApiPhpRequest()
    {
        $cli = 'php ' . $this->systemRoot . '/apps/Sandbox/htdocs/api.php get page://self/index request';
        exec($cli, $return);
        $html = implode('', $return);
        $pos = strpos($html, 'Hello, BEAR.Sunday');
        $this->assertTrue(is_int($pos));
    }
}
