<?php

namespace BEAR\Framework\Tests;

use BEAR\Framework\Framework;
use mockapp\App;
use Guzzle\Common\Cache\CacheAdapterInterface as Cache;
use Guzzle\Common\Cache\Zf2CacheAdapter as CacheAdapter;
use Zend\Cache\Backend\File as CacheBackEnd;


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
    	$cli = 'php ' . $this->systemRoot . '/apps/sandbox/htdocs/web.php get /index';
    	exec($cli, $return);
    	$pos = array_search('<!DOCTYPE html>', $return);
    	$this->assertTrue(is_int($pos));
    }

    public function test_devApiPhp()
    {
    	$cli = 'php ' . $this->systemRoot . '/apps/sandbox/htdocs/api.php get page://self/index';
    	exec($cli, $return);
    	$html = implode('', $return);
    	$pos = strpos($html, 'Hello, BEAR.Sunday');
    	$this->assertTrue(is_int($pos));
    }

    public function test_devApiPhpRep()
    {
    	$cli = 'php ' . $this->systemRoot . '/apps/sandbox/htdocs/api.php get page://self/index view';
    	exec($cli, $return);
    	$html = implode('', $return);
    	$pos = strpos($html, 'Hello, BEAR.Sunday');
    	$this->assertTrue(is_int($pos));
    }

    public function test_devApiPhpValue()
    {
    	$cli = 'php ' . $this->systemRoot . '/apps/sandbox/htdocs/api.php get page://self/index value';
    	exec($cli, $return);
    	$html = implode('', $return);
    	$pos = strpos($html, 'Hello, BEAR.Sunday');
    	$this->assertTrue(is_int($pos));
    }

    public function test_devApiPhpRequest()
    {
    	$cli = 'php ' . $this->systemRoot . '/apps/sandbox/htdocs/api.php get page://self/index request';
    	exec($cli, $return);
    	$html = implode('', $return);
    	$pos = strpos($html, 'Hello, BEAR.Sunday');
    	$this->assertTrue(is_int($pos));
    }
}
